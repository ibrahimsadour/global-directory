<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;



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
