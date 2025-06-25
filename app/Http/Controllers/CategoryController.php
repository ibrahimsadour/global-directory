<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Business;

use Illuminate\Http\Request;

class CategoryController extends Controller
{

    // عرض كل الفئات (أو كل النشاطات)
    public function index()
    {
        // جلب جميع الفئات
        $categories = Category::all();

        // جلب جميع النشاطات (اختياري)
        $businesses = Business::where('is_active', 1)
        ->where('is_approved', 1)
        ->latest()
        ->paginate(3); // عدّل الرقم حسب عدد العناصر في كل صفحة

        // إرسالهم لنفس الصفحة أو صفحة منفصلة حسب تصميمك
        return view('category.index', [
            'categories' => $categories,
            'businesses' => $businesses
            // لا ترسل متغير category هنا
        ]);
    }

    // عرض بيانات فئة معينة مع الأنشطة التابعة لها
    public function show($slug)
    {
        // جلب الفئة حسب الـslug
        $category = Category::where('slug', $slug)->firstOrFail();

        // جلب كل الفئات الفرعية التابعة لهذه الفئة
        $childCategoryIds = $category->children()->pluck('id');

        // دمج ID الفئة الأصلية مع الفئات الفرعية
        $categoryIds = collect([$category->id])->merge($childCategoryIds)->toArray();

        // جلب الأنشطة المرتبطة بهذه الفئات
        $businesses = Business::whereIn('category_id', $categoryIds)
            ->where('is_active', 1)
            ->where('is_approved', 1)
            ->latest()
            ->paginate(10);

        // جلب كل الفئات (للفلتر الجانبي مثلاً)
        $categories = Category::all();

        return view('category.show', [
            'category' => $category,
            'categories' => $categories,
            'businesses' => $businesses
        ]);
    }
}