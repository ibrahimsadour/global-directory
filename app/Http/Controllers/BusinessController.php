<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Services\BusinessService;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\BusinessView; 

class BusinessController extends Controller
{
    public function show($slug, BusinessService $service, Request $request)
    {
        // استدعاء النشاط والبيانات
        $data = $service->showBusinessWithRelated($slug);
        $business = $data['business'];

        // جلب أول 5 تقييمات مرفقة بالمستخدم
        $review = $business->reviews()->with('user')->latest()->take(5)->get();

        // المستخدم الحالي
        $uid = auth()->id();
        $bid = $business->id;

        // جلب تقييم المستخدم الحالي (إن وجد)
        $myReview = $business->reviews()->where('user_id', $uid)->first();

        // ✅ تسجيل المشاهدة (إن لم تُسجّل من نفس IP آخر 6 ساعات)
        $ip = $request->ip();

        $alreadyViewed = BusinessView::where('business_id', $bid)
            ->where('ip', $ip)
            ->where('viewed_at', '>=', now()->subHours(6))
            ->exists();

        if (! $alreadyViewed) {
            BusinessView::create([
                'business_id' => $bid,
                'ip' => $ip,
                'viewed_at' => now(),
            ]);
        }

        // دمج البيانات
        $data = array_merge($data, [
            'review' => $review,
            'uid' => $uid,
            'bid' => $bid,
            'myReview' => $myReview,
        ]);

        return view('business.show', $data);
    }

}
