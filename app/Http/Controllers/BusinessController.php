<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Services\BusinessService;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\BusinessView; 
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class BusinessController extends Controller
{
    public function show($slug, BusinessService $service, Request $request)
    {
        // 1. جلب بيانات النشاط
        $data = $service->showBusinessWithRelated($slug);
        $business = $data['business'];
        $bid = $business->id;

        // 2. جلب التقييمات والمراجعة الشخصية (إن وُجدت)
        $uid = auth()->id();
        $review = $business->reviews()->with('user')->latest()->take(5)->get();
        $myReview = $uid ? $business->reviews()->where('user_id', $uid)->first() : null;

        // 3. التحقق من أن الزائر ليس روبوت (Crawler)
        $userAgent = $request->userAgent();
        $crawler = new CrawlerDetect(null, $userAgent);

        if (! $crawler->isCrawler()) {
            $ip = $request->ip();

            // 4. تسجيل المشاهدة إذا لم تكن مسجلة خلال آخر 6 ساعات
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
        }

        // 5. تمرير البيانات إلى الواجهة
        return view('business.show', array_merge($data, [
            'review' => $review,
            'uid' => $uid,
            'bid' => $bid,
            'myReview' => $myReview,
        ]));
    }

}
