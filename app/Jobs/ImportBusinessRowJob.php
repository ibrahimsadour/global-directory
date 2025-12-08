<?php

namespace App\Jobs;

use App\Models\Business;
use App\Models\Category;
use App\Models\Governorate;
use App\Models\Location;
use App\Models\Seo;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Jobs\Job as LaravelJob;
use Illuminate\Foundation\Bus\Dispatchable;
use Filament\Notifications\Notification;
use Filament\Notifications\Livewire\DatabaseNotifications;
use Throwable;
use Illuminate\Support\Facades\Cache;
use App\Models\BusinessHour;
use Carbon\Carbon;
use App\Models\BusinessGoogleData;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Traits\HandlesWebpImages;


class ImportBusinessRowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use HandlesWebpImages;

    protected $row;
    protected $admin;

    public function __construct(array $row, $admin)
    {
        $this->row = $row;
        $this->admin = $admin;
    }

    public function handle()
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/import-businesses.log'),
        ])->info("🟢 بدأ تنفيذ Job لاستيراد النشاط: " . ($this->row['name'] ?? 'اسم غير معروف'), [
            'row' => $this->row
        ]);

        try {
            $row = $this->row;

            if (
                !User::where('id', $row['user_id'])->exists() ||
                !Category::where('id', $row['category_id'])->exists() ||
                !Location::where('id', $row['location_id'])->exists() ||
                !Governorate::where('id', $row['governorate_id'])->exists()
            ) {
                throw new \Exception("علاقات غير صالحة للنشاط: {$row['name']}");
            }

            $row['latitude'] = floatval($row['latitude']);
            $row['longitude'] = floatval($row['longitude']);

            $address = $row['address'];
            if (empty($address) && is_numeric($row['latitude']) && is_numeric($row['longitude'])) {
                $address = $this->getAddressFromCoordinates($row['latitude'], $row['longitude']);
            }

            $slugSource = $row['slug'] ?? $row['name'];
            $slug = preg_match('/[\p{Arabic}]/u', $slugSource)
                ? preg_replace('/\s+/', '-', trim(preg_replace('/[^\p{Arabic}\p{L}\p{N}\s]/u', '', $slugSource)))
                : Str::slug($slugSource);


            // ✅ تحقق من place_id أولاً
            if (!empty($row['place_id']) && Business::where('place_id', $row['place_id'])->exists()) {
                $message = "ℹ️ النشاط '{$row['name']}' تم تجاهله: place_id مكرر ({$row['place_id']}).";
                Notification::make()->title($message)->warning()->send();

                Log::build([
                    'driver' => 'single',
                    'path' => storage_path('logs/import-businesses.log')
                ])->info($message, [
                    'place_id' => $row['place_id'],
                    'name' => $row['name'],
                ]);

                return;
            }

            // ✅ توليد الـ slug الأساسي
            $slugSource = $row['slug'] ?? $row['name'];
            $slug = preg_match('/[\p{Arabic}]/u', $slugSource)
                ? preg_replace('/\s+/', '-', trim(preg_replace('/[^\p{Arabic}\p{L}\p{N}\s]/u', '', $slugSource)))
                : Str::slug($slugSource);

            // ✅ تحقق من تكرار الـ slug فقط، مع السماح بإنشاء نسخة جديدة باسم المدينة
            if (Business::where('slug', $slug)->exists()) {
                $location = Location::find($row['location_id']);
                $locationName = $location?->area ?? '';

                // تعديل الاسم
                $row['name'] .= ' ' . $locationName;

                // توليد slug جديد بعد إضافة اسم المدينة
                $slugSource = $row['name'];
                $slug = preg_match('/[\p{Arabic}]/u', $slugSource)
                    ? preg_replace('/\s+/', '-', trim(preg_replace('/[^\p{Arabic}\p{L}\p{N}\s]/u', '', $slugSource)))
                    : Str::slug($slugSource);

                // تحقق مرة أخرى بعد التعديل
                if (Business::where('slug', $slug)->exists()) {
                    $message = "ℹ️ النشاط '{$row['name']}' تم تجاهله: slug مكرر ({$slug}) حتى بعد إضافة المدينة.";
                    Notification::make()->title($message)->warning()->send();
                    Log::build(['driver' => 'single', 'path' => storage_path('logs/import-businesses.log')])
                        ->info($message);
                    return;
                }
            }


            // توليد الوصف
            $description = $row['description'] ?? $this->generateDescription(
                $row['name'], $row['category_id'], $row['governorate_id'], $row['phone']
            );

            // 🔧 تنظيف رابط الصورة إن كانت من Google Photos
            if (!empty($row['image']) && str_starts_with($row['image'], 'https://lh3.googleusercontent.com')) {
                $row['image'] = preg_replace('/=w.*$/', '', $row['image']);
            }

            // ✅ تحميل وتحويل الصورة إلى WebP إذا كانت من Google Photos أو أي رابط خارجي
            if (!empty($row['image']) && str_starts_with($row['image'], 'https://')) {
                try {
                    $imageContent = @file_get_contents($row['image']); // استخدم @ لكتم التحذيرات

                    if ($imageContent !== false) {
                        // الحصول على نوع الصورة من الهيدر
                        $headers = @get_headers($row['image'], 1);
                        $contentType = $headers['Content-Type'] ?? null;

                        if (is_array($contentType)) {
                            $contentType = $contentType[0];
                        }

                        // التحقق من نوع الصورة المسموح
                        $extension = match ($contentType) {
                            'image/jpeg' => 'jpg',
                            'image/png'  => 'png',
                            'image/gif'  => 'gif',
                            default      => null,
                        };

                        if ($extension) {
                            // توليد اسم عشوائي للصورة
                            $slug = Str::slug($row['name']);
                            $filename = 'business_photos/from-google/' . $slug . '-' . Str::random(6) . '.' . $extension;

                            // حفظ الصورة الأصلية في storage
                            Storage::disk('public')->put($filename, $imageContent);

                            // ✅ التحويل إلى WebP وضغطها
                            $webpPath = $this->convertImageToWebpIfNeeded($filename);
                            $row['image'] = $webpPath;
                        } else {
                            // ❌ نوع صورة غير مدعوم، نستخدم الصورة الافتراضية
                            $row['image'] = 'business_photos/default.webp';
                            Log::warning("⚠️ نوع غير مدعوم للصورة: $contentType");
                        }
                    } else {
                        // فشل تحميل الصورة
                        $row['image'] = 'business_photos/default.webp';
                        Log::warning("⚠️ فشل تحميل الصورة من الرابط: " . $row['image']);
                    }
                } catch (\Exception $e) {
                    // استثناء عام
                    $row['image'] = 'business_photos/default.webp';
                    Log::warning("⚠️ فشل عام في تحميل أو تحويل الصورة: " . $e->getMessage());
                }
            }

            
            // إنشاء النشاط
            $business = Business::create([
                'user_id' => $row['user_id'],
                'category_id' => $row['category_id'],
                'location_id' => $row['location_id'],
                'governorate_id' => $row['governorate_id'],
                'name' => $row['name'],
                'slug' => $slug,
                'address' => $address,
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'website' => $row['website'],
                'whatsapp' => $row['phone'], //بالوقت الحالي تمت الاضافة نفس رقم الهاتف لتجنب الاخطاء
                'description' => $description,
                'is_featured' => 0,
                'is_approved' => 1,
                'is_active' => 1,
                'image' => $row['image'],
                'place_id' => $row['place_id'] ?? null,
            ]);

            //  حفظ روابط السوشيال
            $this->saveSocialLinks($business, $row);

            // ✅ معالجة أوقات الدوام إن وجدت
            if (!empty($row['opening_hours']) && is_string($row['opening_hours'])) {
                $daysData = explode(',', $row['opening_hours']);

                foreach ($daysData as $entry) {
                    $entry = trim($entry);

                    // التعبير المنتظم المعدل: يدعم الأقواس المربعة الاختيارية
                    // (?:\[?(.+?)\]?) : يلتقط الوقت سواء كان بين [] أو لا.
                    // مثال: السبت:[٦:٠٠ص-٢:٠٠ص] أو الاثنين:٨:٣٠ص–٢:١٠م
                    if (preg_match('/^(.+?):(?:\[?(.+?)\]?)$/u', $entry, $matches)) {
                        $day = trim($matches[1]);
                        $hours = trim($matches[2]); // هذا الآن هو نطاق الوقت أو كلمة 'مغلق'

                        // 💡 1. التحقق من حالة الإغلاق (مغلق، Closed، إلخ)
                        if (Str::contains($hours, ['مغلق', 'Closed', 'closed'])) {
                            // إذا كان اليوم مغلقاً، ننتقل مباشرة إلى اليوم التالي دون محاولة حفظ سجل له.
                            continue; 
                        }
                        
                        try {
                            // 2. التحقق من حالة الدوام 24 ساعة
                            if (Str::contains($hours, ['Open 24 hours', 'نعمل على مدار 24 ساعة'])) {
                                BusinessHour::create([
                                    'business_id' => $business->id,
                                    'day'         => $day,
                                    'open_time'   => '00:00:00',
                                    'close_time'  => '23:59:59',
                                ]);
                            } 
                            
                            // 3. التحقق من نطاق زمني مفتوح (سواء استخدم – أو -)
                            elseif (Str::contains($hours, ['–', '-'])) {
                                
                                // تقسيم الوقت بناءً على الشرطتين (القصيرة أو الطويلة)
                                [$open, $close] = preg_split('/–|-/', $hours);
                                
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
                            Log::warning("فشل في حفظ وقت الدوام لـ {$day} في النشاط {$business->name}: {$hours} | السبب: {$e->getMessage()}");
                        }
                    }
                }
            }

            // ✅ استيراد بيانات Google الإضافية إن توفرت
            if (!empty($row['place_id'])) {
                $googleData = [];

                if (!empty($row['google_maps_url'])) {
                    $googleData['google_maps_url'] = $row['google_maps_url'];
                }
                if (!empty($row['google_reviews_url'])) {
                    $googleData['google_reviews_url'] = $row['google_reviews_url'];
                }
                if (!empty($row['google_rating'])) {
                    $googleData['google_rating'] = floatval($row['google_rating']);
                }
                if (!empty($row['google_reviews_count'])) {
                    $googleData['google_reviews_count'] = intval($row['google_reviews_count']);
                }

                if (!empty($googleData)) {
                    $business->googleData()->updateOrCreate(
                        ['business_id' => $business->id],
                        $googleData
                    );
                }
            }


            // ارسال النتيجة الى قسم نتائج الاستيراد
            Cache::increment('imported_count_user_' . $this->admin->id);

            
            // توليد السيو
            $seo = $this->generateSeo($business->name);
            $business->seo()->create($seo);

            // إشعار نجاح
            Notification::make()
                ->title("✅ تم إضافة: {$business->name}")
                ->success()
                ->send();

        } catch (Throwable $e) {
            Notification::make()
                ->title("❌ فشل إضافة النشاط: {$this->row['name']}")
                ->body("السبب: " . $e->getMessage())
                ->danger()
                ->send();

            Log::build(['driver' => 'single', 'path' => storage_path('logs/import-businesses.log')])
                ->error("❌ فشل استيراد النشاط: {$this->row['name']}", [
                    'exception_message' => $e->getMessage(),
                    'row_data' => $this->row,
                    'trace' => $e->getTraceAsString()
                ]);
        }

    }

    protected function normalizeTime($time)
    {
        $arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩','ص','م'];
        $english = ['0','1','2','3','4','5','6','7','8','9','AM','PM'];

        $time = str_replace($arabic, $english, $time);
        $time = preg_replace('/(\\d)(AM|PM)/i', '$1 $2', $time);

        return $time;
    }

    private function getAddressFromCoordinates($lat, $lng)
    {
        $apiKey = config('services.google_maps.key');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&language=ar&key={$apiKey}";
        $response = Http::get($url);

        return $response['results'][0]['formatted_address'] ?? 'عنوان غير متوفر';
    }

    private function generateDescription($name, $categoryId, $governorateId, $phone)
    {
        try {
            $siteAddress = setting('site_address');

            // ✅ مصفوفة توصيف نوع النشاط حسب الفئة الرئيسية
            $categoryTypes = [
                1 => 'مطعم أو مكان يقدم مأكولات ومشروبات',
                2 => 'محل أو مركز تسوق يقدم منتجات متنوعة',
                3 => 'مركز أو منشأة طبية أو صيدلية أو مستشفى',
                4 => 'شركة تقدم خدمات مهنية أو منزلية أو تقنية',
                5 => 'مركز تعليمي أو مؤسسة تعليمية أو تدريبية',
                6 => 'مكان ترفيهي أو سياحي أو خدمات سفر',
                7 => 'شركة أو مكتب عقاري أو خدمات بناء',
                8 => 'جهة مالية أو مصرفية أو خدمات أعمال',
                9 => 'كراج أو خدمة سيارات أو بيع وشراء مركبات',
                10 => 'مكان ديني أو اجتماعي أو خيري',
                86 => 'بعثة دبلوماسية مثل سفارة أو قنصلية',
            ];

            $category = \App\Models\Category::find($categoryId);
            $parentId = $category?->parent_id ?? $category?->id;
            $typeDescription = $categoryTypes[$parentId] ?? 'نشاط تجاري أو خدمي داخل الكويت';

            // ✅ توليد البرومبت الذكي بناءً على نوع النشاط
            $prompt = "اكتب وصفًا واضحًا باللغة العربية لنشاط من نوع {$typeDescription} باسم \"{$name}\" يقع في منطقة \"{$siteAddress}\" داخل الكويت. اجعل الوصف واقعيًا ومختصرًا ويعكس نوع الخدمة أو الجهة. لا يتجاوز 60 كلمة.";

            $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [['role' => 'user', 'content' => $prompt]],
            ]);

            if ($response->successful()) {
                return trim($response['choices'][0]['message']['content']);
            }
        } catch (\Exception $e) {
            Log::error("فشل توليد وصف النشاط: " . $e->getMessage());
        }

        // ✅ وصف احتياطي في حال فشل الذكاء الصناعي
        $cat = \App\Models\Category::find($categoryId)?->name ?? 'الخدمة';
        $gov = \App\Models\Governorate::find($governorateId)?->name ?? 'المحافظة';
        return "نقدم خدمات {$cat} في {$gov}. للتواصل: {$phone}";
    }


    private function generateSeo($name): array
    {
        try {
            $prompt = "أعطني Meta Title و Meta Description و Meta Keywords باللغة العربية حيث يستهدف السوق المحلي في الكويت فقط لنشاط اسمه '{$name}'.";
            $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [['role' => 'user', 'content' => $prompt]],
            ]);

            if ($response->successful()) {
                $text = $response['choices'][0]['message']['content'];
                preg_match('/meta\s*title[:：]?\s*(.+)/i', $text, $titleMatch);
                preg_match('/meta\s*description[:：]?\s*(.+)/i', $text, $descMatch);
                preg_match('/meta\s*keywords[:：]?\s*(.+)/i', $text, $keyMatch);

                return [
                    'meta_title' => $titleMatch[1] ?? $name,
                    'meta_description' => $descMatch[1] ?? $name,
                    'meta_keywords' => $keyMatch[1] ?? $name,
                ];
            }
        } catch (\Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/import-businesses.log'),
            ])->error("❌ فشل توليد بيانات السيو", [
                'exception_message' => $e->getMessage(),
                'business_name' => $name,
                'trace' => $e->getTraceAsString(),
            ]);

        }

        return [
            'meta_title' => $name,
            'meta_description' => $name,
            'meta_keywords' => $name,
        ];
    }

    //  حفظ روابط السوشيال
    private function saveSocialLinks(Business $business, array $row): void
    {
        $socialFields = ['facebook', 'instagram', 'twitter', 'linkedin', 'youtube', 'tiktok'];
        $socialData = [];

        foreach ($socialFields as $field) {
            if (!empty($row[$field] ?? null)) {
                $socialData[$field] = $row[$field];
            }
        }

        if (!empty($socialData)) {
            $business->socialLinks()->updateOrCreate(
                ['business_id' => $business->id],
                $socialData
            );
        }
    }

}
