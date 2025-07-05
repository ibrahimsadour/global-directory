<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Governorate;


function getAddressFromCoordinates($lat, $lng): ?string
    {
        if (empty($lat) || empty($lng) || !is_numeric($lat) || !is_numeric($lng)) {
            return null;
        }

        $apiKey = config('services.google_maps.key');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key={$apiKey}&language=ar";

        $response = Http::get($url);

        if (!$response->ok()) {
            Log::warning('فشل الاتصال بواجهة Google Maps', ['status' => $response->status()]);
            return null;
        }

        $data = $response->json();

        if ($data['status'] !== 'OK') {
            Log::warning('فشل في جلب العنوان', ['status' => $data['status'], 'message' => $data['error_message'] ?? '']);
            return null;
        }

        // 1. فلترة النتائج الواقعية حسب نوعها
        $result = collect($data['results'])->first(function ($r) {
            return isset($r['types']) &&
                collect($r['types'])->intersect(['street_address', 'route', 'neighborhood', 'sublocality', 'locality'])->isNotEmpty() &&
                !preg_match('/^\s*[A-Z0-9]+\+\w+/', $r['formatted_address'] ?? '');
        });

        // 2. إذا لم نجد نتيجة مناسبة، استبعد Plus Code
        if (!$result) {
            $result = collect($data['results'])->first(function ($r) {
                return !preg_match('/^\s*[A-Z0-9]+\+\w+/', $r['formatted_address'] ?? '');
            });
        }

        // 3. fallback: أول نتيجة
        if (!$result && isset($data['results'][0])) {
            $result = $data['results'][0];
        }

        return $result['formatted_address'] ?? null;
    }



if (! function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        return \App\Models\Setting::where('key', $key)->value('value') ?? $default;
    }
}

/**
 * جلب الفئات النشطة للعرض في الفوتر أو أي مكان آخر
 * 
 * @return \Illuminate\Database\Eloquent\Collection|string
 */
function categories()
    {
        try {
            $categories = \App\Models\Category::where('is_active', 1)
                ->orderBy('name')
                ->get(['id', 'name', 'slug']); // تحديد الحقول المطلوبة فقط
            
            return $categories->isEmpty() ? 'no_active_categories' : $categories;
            
        } catch (\Exception $e) {
            
            return 'categories_error';
        }
    }

if (!function_exists('generateBusinessSeoData')) {
    /**
     * توليد بيانات السيو (Meta Title, Meta Description, Meta Keywords) لنشاط معين باستخدام OpenAI
     *
     * @param string $name اسم النشاط التجاري
     * @return array يحتوي على meta_title و meta_description و meta_keywords
     */
    function generateBusinessSeoData($name): array
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
            Log::error("فشل توليد بيانات السيو: " . $e->getMessage());
        }

        // في حال الفشل نرجع الاسم كقيم افتراضية
        return [
            'meta_title' => $name,
            'meta_description' => $name,
            'meta_keywords' => $name,
        ];
    }
}



/**
 * توليد وصف تسويقي دقيق للنشاط التجاري بناءً على الاسم والفئة والموقع
 */
function generateBusinessDescription(string $name, int $categoryId, int $governorateId, ?string $phone = null): string
    {
        try {
            $category = \App\Models\Category::find($categoryId)?->name ?? 'الخدمة';
            $governorate = \App\Models\Governorate::find($governorateId)?->name ?? 'الكويت';
            $cleanName = Str::of($name)->limit(30)->__toString();

            $prompt = <<<EOT
    أنت كاتب محتوى تسويقي محترف. أكتب وصفًا تسويقيًا واضحًا ومباشرًا باللغة العربية لخدمة اسمها "{$cleanName}" وهي تندرج ضمن فئة "{$category}" وتقدم في محافظة "{$governorate}". استخدم أسلوبًا احترافيًا بسيطًا يستهدف السوق المحلي في الكويت فقط. لا تتجاوز 60 كلمة. ركز على الفائدة الحقيقية للخدمة وتجنب العبارات الغامضة أو العامة.
    EOT;

            $response = \Illuminate\Support\Facades\Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [['role' => 'user', 'content' => $prompt]],
            ]);

            if ($response->successful()) {
                return trim($response['choices'][0]['message']['content']);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("فشل توليد وصف النشاط: " . $e->getMessage());
        }

        // fallback في حال فشل الذكاء الاصطناعي
        $category = \App\Models\Category::find($categoryId)?->name ?? 'الخدمة';
        $gov = \App\Models\Governorate::find($governorateId)?->name ?? 'الكويت';
        return "نقدم خدمات {$category} في {$gov} مع توفير جودة وراحة عالية. للتواصل: {$phone}";
    }   


if (!function_exists('generateBusinessDescription')) {
    /**
     * توليد وصف تسويقي مختصر للنشاط باستخدام OpenAI
     */
    function generateBusinessDescription(string $name, int $categoryId, int $governorateId, ?string $phone = ''): string
    {
        try {
            $siteAddress = setting('site_address') ?? 'الكويت';
            $category = Category::find($categoryId)?->name ?? 'خدمة';
            $governorate = Governorate::find($governorateId)?->name ?? 'منطقة';

            // صياغة البرومبت بدقة
            $prompt = "اكتب وصفًا تسويقيًا واضحًا باللغة العربية لخدمة اسمها \"{$name}\"، ضمن فئة {$category}، وتخدم منطقة {$governorate} في {$siteAddress}. لا يتجاوز 60 كلمة.";

            $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            if ($response->successful()) {
                return trim($response['choices'][0]['message']['content'], " \t\n\r\0\x0B\"");
            }
        } catch (\Exception $e) {
            Log::error("فشل توليد وصف النشاط: " . $e->getMessage());
        }

        // بديل في حال فشل الذكاء الاصطناعي
        return "خدمة {$name} المميزة ضمن منطقة {$governorate}. اتصل بنا لمزيد من التفاصيل.";
    }
}

if (!function_exists('generateBusinessSeo')) {
    /**
     * توليد Meta Title و Meta Description و Meta Keywords باستخدام OpenAI
     *
     * @param string $name
     * @param int $categoryId
     * @param int $governorateId
     * @return array
     */
    function generateBusinessSeo(string $name, int $categoryId, int $governorateId): array
    {
        try {
            $category = Category::find($categoryId)?->name ?? 'خدمة';
            $governorate = Governorate::find($governorateId)?->name ?? 'الكويت';
            $prompt = "اكتب لي Meta Title وMeta Description وMeta Keywords باللغة العربية لنشاط تجاري اسمه '{$name}'، يقدم خدمات ضمن فئة {$category} في منطقة {$governorate} في الكويت، ويستهدف السوق المحلي فقط. اجعل النصوص جذابة، واضحة، وتراعي قواعد السيو. لا تستخدم علامات تنصيص أو فواصل غير ضرورية.";

            $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            if ($response->successful()) {
                $content = $response['choices'][0]['message']['content'];

                // استخراج البيانات
                preg_match('/meta\s*title[:：]?\s*(.+)/i', $content, $titleMatch);
                preg_match('/meta\s*description[:：]?\s*(.+)/i', $content, $descMatch);
                preg_match('/meta\s*keywords[:：]?\s*(.+)/i', $content, $keywordsMatch);

                return [
                    'meta_title'       => trim($titleMatch[1] ?? $name, " \t\n\r\0\x0B\""),
                    'meta_description' => trim($descMatch[1] ?? $name, " \t\n\r\0\x0B\""),
                    'meta_keywords'    => trim($keywordsMatch[1] ?? $name, " \t\n\r\0\x0B\""),
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
