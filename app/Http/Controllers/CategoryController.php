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
        $businesses = Business::latest()->paginate(15);

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

        // جلب الأنشطة المرتبطة بهذه الفئة
        $businesses = $category->businesses()->latest()->paginate(15);

        // جلب كل الفئات (للفلتر الجانبي مثلاً)
        $categories = Category::all();

        return view('category.show', [
            'category' => $category,
            'categories' => $categories,
            'businesses' => $businesses
        ]);
    }
}