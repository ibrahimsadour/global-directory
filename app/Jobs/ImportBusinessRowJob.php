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

class ImportBusinessRowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $row;
    protected $admin;

    public function __construct(array $row, $admin)
    {
        $this->row = $row;
        $this->admin = $admin;
    }

    public function handle()
    {
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

            $description = $row['description'] ?? $this->generateDescription(
                $row['name'],
                $row['category_id'],
                $row['governorate_id'],
                $row['phone']
            );

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
                'whatsapp' => $row['whatsapp'],
                'description' => $description,
                'is_featured' => $row['is_featured'],
                'is_approved' => $row['is_approved'],
                'is_active' => $row['is_active'],
                'image' => $row['image'],
                'facebook' => $row['facebook'],
                'instagram' => $row['instagram'],
                'twitter' => $row['twitter'],
                'linkedin' => $row['linkedin'],
                'youtube' => $row['youtube'],
            ]);

            $seo = $this->generateSeo($business->name);
            $business->seo()->create($seo);

            // ✅ إشعار نجاح
            Notification::make()
                ->title("✅ تم إضافة: {$business->name}")
                ->success()
                ->send();

        } catch (Throwable $e) {
            // ✅ إشعار فشل
            Notification::make()
                ->title("❌ فشل إضافة النشاط: {$this->row['name']}")
                ->body("السبب: " . $e->getMessage())
                ->danger()
                ->send();

            Log::error("فشل استيراد النشاط {$this->row['name']}: " . $e->getMessage());
        }
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
            $prompt = "اكتب وصفًا تسويقيًا واضحًا باللغة العربية لخدمة اسمها \"{$name}\"، وتخدم منطقة \"{$siteAddress}\". لا يتجاوز 50 كلمة.";
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

        $cat = Category::find($categoryId)?->name ?? 'الخدمة';
        $gov = Governorate::find($governorateId)?->name ?? 'المحافظة';
        return "نقدم خدمات {$cat} في {$gov}. للتواصل: {$phone}";
    }

    private function generateSeo($name): array
    {
        try {
            $prompt = "أعطني Meta Title و Meta Description و Meta Keywords باللغة العربية لنشاط اسمه '{$name}'.";
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
            Log::error("فشل توليد بيانات السيو: " . $e->getMessage());
        }

        return [
            'meta_title' => $name,
            'meta_description' => $name,
            'meta_keywords' => $name,
        ];
    }
}
