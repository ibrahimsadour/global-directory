<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\SearchRecord; 

class SearchController extends Controller
{
public function index(Request $request)
{
    $keyword = $request->input('search_key');
    
    // 1. تنظيف الكلمة المفتاحية واستخراج الكلمات الفردية الصالحة
    // يتم تقسيم الجملة إلى كلمات، ثم إزالة أي قيم فارغة (مثل المسافات الزائدة)
    $keywords = array_filter(explode(' ', $keyword)); 

    // تخزين الكلمة البحثية في قاعدة البيانات (فقط إذا كانت هناك كلمة بحث صالحة)
    if (!empty($keyword)) { // نستخدم $keyword الأصلي للتخزين
        SearchRecord::create([
            'search_term' => $keyword,
        ]);
    }

    $query = Business::where('is_active', 1)
                     ->where('is_approved', 1);

    // 2. تطبيق شروط البحث فقط إذا كانت هناك كلمات مفردة للبحث
    if (!empty($keywords)) {
        
        $query->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                
                // 3. استخدام ORWHERE لضمان العثور على أي كلمة في الاسم أو الوصف
                // 💡 نستخدم '%{$word}%' للبحث عن الكلمة في أي مكان داخل النص (بحث شامل)
                // إذا كنت تفضل البحث عن الكلمة في بداية النص فقط، استخدم '{$word}%'
                $q->orWhere('name', 'like', "%{$word}%")
                  ->orWhere('description', 'like', "%{$word}%");
            }
        });
    }

    $businesses = $query->latest()->paginate(10);

    return view('search.index', [
        'businesses' => $businesses,
        'keyword' => $keyword,
    ]);
}
}