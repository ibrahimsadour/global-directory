<?php

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
