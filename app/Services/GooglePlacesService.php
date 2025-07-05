<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Location;
use App\Models\Governorate;
use App\Models\Category;

use App\Models\Business;
use Illuminate\Support\Collection;
use App\Models\ImportLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\BusinessHour;

class GooglePlacesService
{
    protected string $apiKey;
    public ?string $governorateName = null;
    public ?string $locationName = null;
    public ?string $categoryName = null;

    protected function normalizeTime(string $time): string
    {
        // استبدال الرموز العربية والاختصارات لتسهيل التحليل
        $replacements = [
            'ص' => 'AM',
            'م' => 'PM',
            'ص.' => 'AM',
            'م.' => 'PM',
            '–' => '-', // في حال ظهرت داخل الوقت
            '٫' => ':', // نقطة عربية
            ' ' => ' ', // مسافات خاصة
            ' ' => ' ', // مسافات نحيلة
        ];

        $normalized = strtr($time, $replacements);

        // تأكد أن الساعة تحتوي على AM أو PM
        if (!Str::contains($normalized, ['AM', 'PM'])) {
            // إذا لم يكن بها AM/PM نحاول تحديدها بناءً على الرقم (افتراضي قبل 12 ظهرًا AM)
            $hour = (int)trim(Str::before($normalized, ':'));
            $normalized .= $hour < 12 ? ' AM' : ' PM';
        }

        return trim($normalized);
    }

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.key');
    }

    public function fetchFullPlacesDetails(string $keyword, Location $location): Collection
    {
        $latitude = $location->latitude;
        $longitude = $location->longitude;
        $nearbyUrl = 'https://maps.googleapis.com/maps/api/place/textsearch/json';

        $places = collect();
        $page = 0;
        $nextPageToken = null;

        do {
            $params = [
                'query'    => $keyword,
                'location' => "$latitude,$longitude",
                'key'      => $this->apiKey,
                'language' => 'ar',
            ];

            if ($nextPageToken) {
                $params['pagetoken'] = $nextPageToken;
                sleep(2); // Google requires a short delay before using the next page token
            }

            $response = Http::retry(3, 100)->get($nearbyUrl, $params);

            if ($response->failed()) {
                throw new \Exception('فشل في الاتصال بـ Google Places API');
            }

            $results = collect($response->json('results') ?? []);
            $places = $places->merge($results);

            $nextPageToken = $response->json('next_page_token') ?? null;
            $page++;

        } while ($nextPageToken && $page < 3); // Google API يدعم فقط 3 صفحات كحد أقصى (20 × 3 = 60 نتيجة)

        // ✅ تحميل مضلع المدينة من قاعدة البيانات
        $polygon = json_decode($location->polygon, true)['coordinates'] ?? null;

        if ($polygon) {
            $places = $places->filter(function ($place) use ($polygon) {
                $lat = $place['geometry']['location']['lat'] ?? null;
                $lng = $place['geometry']['location']['lng'] ?? null;

                if (!$lat || !$lng) return false;

                return $this->pointInPolygon($lng, $lat, $polygon);
            })->values();
        }

        return $places->map(function ($place) {
            $details = $this->getPlaceDetails($place['place_id']);
            $result = $details['result'] ?? $place;

            return [
                'place_id'      => $result['place_id'] ?? null,
                'name'          => $result['name'] ?? 'بدون اسم',
                'address'       => $result['formatted_address'] ?? $result['vicinity'] ?? null,
                'latitude'      => $result['geometry']['location']['lat'] ?? null,
                'longitude'     => $result['geometry']['location']['lng'] ?? null,
                'phone'         => $result['formatted_phone_number'] ?? null,
                'website'       => $result['website'] ?? null,
                'rating'        => $result['rating'] ?? null,
                'reviews_count' => $result['user_ratings_total'] ?? null,
                'photo_url'     => isset($result['photos'][0]['photo_reference']) ?
                    "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photo_reference={$result['photos'][0]['photo_reference']}&key={$this->apiKey}" : null,
                'opening_hours' => $result['opening_hours']['weekday_text'] ?? [],
                'types'         => $result['types'] ?? [],
            ];
        });
    }

    protected function getPlaceDetails(string $placeId): array
    {
        $detailsUrl = 'https://maps.googleapis.com/maps/api/place/details/json';
        $response = Http::retry(3, 100)->get($detailsUrl, [
            'place_id' => $placeId,
            'key' => $this->apiKey,
            'language' => 'ar',
        ]);

        return $response->successful() ? $response->json() : [];
    }

    public function storeBusinesses(Collection $places, array $meta): int
    {
        $saved = 0;

        foreach ($places as $place) {
            if (empty($place['place_id']) || Business::where('place_id', $place['place_id'])->exists()) {
                continue;
            }

            // 🔤 توليد اسم اللينك
            $slugSource = $place['name'] ?? 'نشاط-بدون-اسم';

            $slug = preg_match('/[\p{Arabic}]/u', $slugSource)
                ? preg_replace('/\s+/', '-', trim(preg_replace('/[^\p{Arabic}\p{L}\p{N}\s]/u', '', $slugSource)))
                : Str::slug($slugSource);

            $originalSlug = $slug;
            $counter = 1;

            // ✅ تحقق من وجود slug مكرر وقم بإضافة رقم فقط عند الحاجة
            while (\App\Models\Business::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }



            // إنشاء النشاط التجاري
            $business = Business::create([
                'name'           => $place['name'] ?? 'بدون اسم',
                'slug'           => $slug,
                'address'        => $place['address'] ?? null,
                'phone'          => $place['phone'] ?? null,
                'email'          => null,
                'website'        => $place['website'] ?? null,
                'whatsapp'       => null,
                'description'    => null,
                'latitude'       => $place['latitude'] ?? null,
                'longitude'      => $place['longitude'] ?? null,
                'place_id'       => $place['place_id'],
                'user_id'        => auth()->id(),
                'governorate_id' => $meta['governorate_id'],
                'location_id'    => $meta['location_id'],
                'category_id'    => $meta['category_id'],
                'rating'         => $place['rating'] ?? null,
                'reviews_count'  => $place['reviews_count'] ?? null,
                'image'          => $place['photo_url'] ?? null,
                'gallery'        => null,
                'facebook'       => null,
                'instagram'      => null,
                'twitter'        => null,
                'linkedin'       => null,
                'youtube'        => null,
                'is_featured'    => false,
                'is_approved'    => true,
                'is_active'      => true,
            ]);

            dispatch(new \App\Jobs\GenerateSeoForBusiness($business));


            // ✅ حفظ أوقات العمل إن وُجدت
            if (!empty($place['opening_hours']) && is_array($place['opening_hours'])) {
                foreach ($place['opening_hours'] as $entry) {
                    // مثال: "السبت: 7:00 ص – 11:00 م"
                    if (preg_match('/^(.+?):\s*(.+)$/u', $entry, $matches)) {
                        $day = trim($matches[1]);
                        $hours = trim($matches[2]);

                        try {
                            if (Str::contains($hours, ['Open 24 hours', 'نعمل على مدار 24 ساعة'])) {
                                // 🟢 دوام كامل
                                BusinessHour::create([
                                    'business_id' => $business->id,
                                    'day'         => $day,
                                    'open_time'   => '00:00:00',
                                    'close_time'  => '23:59:59',
                                ]);
                            } elseif (Str::contains($hours, ['–', '-'])) {
                                // 🕒 تنسيق وقت مفتوح
                                [$open, $close] = preg_split('/–|-/', $hours);

                                // ✅ تحويل الوقت العربي إلى إنجليزي لتفادي أخطاء parsing
                                $open = $this->normalizeTime(trim($open));
                                $close = $this->normalizeTime(trim($close));

                                BusinessHour::create([
                                    'business_id' => $business->id,
                                    'day'         => $day,
                                    'open_time'   => Carbon::parse($open)->format('H:i:s'),
                                    'close_time'  => Carbon::parse($close)->format('H:i:s'),
                                ]);
                            }
                        } catch (\Exception $e) {
                            Log::warning("فشل في حفظ وقت الدوام لـ {$day} في النشاط {$business->name}: {$hours}");
                        }
                    }
                }
            }

            $saved++;
        }

        // 📝 حفظ سجل الاستيراد
        ImportLog::create([
            'user_id'       => auth()->id(),
            'city_id'       => $meta['location_id'],
            'category_id'   => $meta['category_id'],
            'keyword'       => $meta['keyword'],
            'imported_at'   => now(),
            'total_fetched' => $places->count(),
            'new_saved'     => $saved,
        ]);

        return $saved;
    }


    protected function pointInPolygon(float $lng, float $lat, array $polygon): bool
    {
        $inside = false;
        $points = $polygon[0]; // نستخدم أول مضلع فقط
        $j = count($points) - 1;

        for ($i = 0; $i < count($points); $i++) {
            $xi = $points[$i][1];
            $yi = $points[$i][0];
            $xj = $points[$j][1];
            $yj = $points[$j][0];

            $intersect = (($yi > $lng) != ($yj > $lng)) &&
                        ($lat < ($xj - $xi) * ($lng - $yi) / (($yj - $yi) ?: 0.0000001) + $xi);

            if ($intersect) {
                $inside = !$inside;
            }
            $j = $i;
        }

        return $inside;
    }

}
