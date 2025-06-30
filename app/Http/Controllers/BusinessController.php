<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Services\BusinessService;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
class BusinessController extends Controller
{
    public function show($slug, BusinessService $service)
    {
        // استدعاء الخدمة للحصول على النشاط والإعلانات المشابهة وبيانات السيو
        $data = $service->showBusinessWithRelated($slug);

        $business = $data['business'];

        // جلب أول 5 تقييمات مرفقة بالمستخدم
        $review = $business->reviews()->with('user')->latest()->take(5)->get();

        // المستخدم الحالي
        $uid = auth()->id();

        // معرف النشاط
        $bid = $business->id;

        // جلب تقييم المستخدم الحالي (إن وجد)
        $myReview = $business->reviews()->where('user_id', $uid)->first();

        // دمج البيانات مع البيانات السابقة
        $data = array_merge($data, [
            'review' => $review,
            'uid' => $uid,
            'bid' => $bid,
            'myReview' => $myReview,
        ]);

        return view('business.show', $data);
    }

}
