<?php

namespace App\Imports;

use App\Models\Business;
use App\Models\Seo;
use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use App\Models\Governorate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

if (!function_exists('isValidLatitude')) {
    function isValidLatitude($lat) {
        return is_numeric($lat) && $lat >= -90 && $lat <= 90;
    }
}

if (!function_exists('isValidLongitude')) {
    function isValidLongitude($lng) {
        return is_numeric($lng) && $lng >= -180 && $lng <= 180;
    }
}

class BusinessesImport implements ToModel, WithHeadingRow
{
    public static array $errors = [];

    public function model(array $row)
    {
        $relationsValid = true;

        if (!User::where('id', $row['user_id'])->exists()) {
            self::$errors[] = "خطأ في user_id ({$row['user_id']}) في السطر الخاص بالاسم: {$row['name']}";
            $relationsValid = false;
        }

        if (!Category::where('id', $row['category_id'])->exists()) {
            self::$errors[] = "خطأ في category_id ({$row['category_id']}) في السطر الخاص بالاسم: {$row['name']}";
            $relationsValid = false;
        }

        if (!Location::where('id', $row['location_id'])->exists()) {
            self::$errors[] = "خطأ في location_id ({$row['location_id']}) في السطر الخاص بالاسم: {$row['name']}";
            $relationsValid = false;
        }

        if (!Governorate::where('id', $row['governorate_id'])->exists()) {
            self::$errors[] = "خطأ في governorate_id ({$row['governorate_id']}) في السطر الخاص بالاسم: {$row['name']}";
            $relationsValid = false;
        }

        if (!$relationsValid) return null;

        $row['latitude'] = floatval($row['latitude']);
        $row['longitude'] = floatval($row['longitude']);

        $address = $row['address'];
        if (empty($address) && isValidLatitude($row['latitude']) && isValidLongitude($row['longitude'])) {
            $address = getAddressFromCoordinates($row['latitude'], $row['longitude']);
        }

        $slugSource = $row['slug'] ?? $row['name'];
        if (preg_match('/[\p{Arabic}]/u', $slugSource)) {
            $slug = preg_replace('/[^\p{Arabic}\p{L}\p{N}\s]/u', '', $slugSource);
            $slug = preg_replace('/\s+/', '-', trim($slug));
        } else {
            $slug = Str::slug($slugSource);
        }

        // توليد الوصف إذا لم يكن موجوداً
        $description = $row['description'];
        if (empty($description)) {
            try {
                $openAiKey = env('OPENAI_API_KEY');

                $businessName = $row['name'];
                $siteAddress = setting('site_address');
                $prompt = "اكتب وصفًا تسويقيًا واضحًا باللغة العربية لخدمة اسمها \"{$businessName}\"، وتخدم منطقة \"{$siteAddress}\". اجعله طبيعيًا، جذابًا، ولا يتجاوز 50 كلمة. تجنب التكرار أو نسخ محتوى السيو.";

                $response = Http::withToken($openAiKey)->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ],
                ]);

                if ($response->successful()) {
                    $aiText = $response['choices'][0]['message']['content'];
                    $description = trim($aiText);
                }
            } catch (\Exception $e) {
                Log::error('فشل توليد وصف النشاط من OpenAI: ' . $e->getMessage());
            }

            if (empty($description)) {
                $categoryName = Category::find($row['category_id'])->name ?? 'الخدمة';
                $governorateName = Governorate::find($row['governorate_id'])->name ?? 'المحافظة';
                $description = "نقدم خدمات {$categoryName} في {$governorateName}. لمزيد من المعلومات، تواصل معنا عبر {$row['phone']}.";
            }
        }

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

        if ($business) {
            $metaTitle = $row['meta_title'] ?? null;
            $metaDescription = $row['meta_description'] ?? null;
            $metaKeywords = $row['meta_keywords'] ?? null;

            if (!$metaTitle || !$metaDescription || !$metaKeywords) {
                try {
                    $openAiKey = env('OPENAI_API_KEY');
                    $prompt = "أعطني Meta Title و Meta Description و Meta Keywords باللغة العربية لنشاط اسمه '{$business->name}'.";

                    $response = Http::withToken($openAiKey)->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-3.5-turbo',
                        'messages' => [
                            ['role' => 'user', 'content' => $prompt]
                        ],
                    ]);

                    if ($response->successful()) {
                        $aiText = $response['choices'][0]['message']['content'];

                        preg_match('/meta\s*title[:：]?\s*(.+)/i', $aiText, $titleMatch);
                        preg_match('/meta\s*description[:：]?\s*(.+)/i', $aiText, $descriptionMatch);
                        preg_match('/meta\s*keywords[:：]?\s*(.+)/i', $aiText, $keywordsMatch);

                        $metaTitle = $metaTitle ?? trim($titleMatch[1] ?? $business->name);
                        $metaDescription = $metaDescription ?? trim($descriptionMatch[1] ?? $business->name);
                        $metaKeywords = $metaKeywords ?? trim($keywordsMatch[1] ?? $business->name);
                    }
                } catch (\Exception $e) {
                    Log::error('فشل توليد بيانات السيو من OpenAI: ' . $e->getMessage());
                }
            }

            $business->seo()->create([
                'meta_title' => $metaTitle ?? $business->name,
                'meta_description' => $metaDescription ?? $business->name,
                'meta_keywords' => $metaKeywords ?? $business->name,
            ]);
        }

        return $business;
    }
}
