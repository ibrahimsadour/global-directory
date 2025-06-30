<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:5|max:1000',
        ]);

        // ✅ تحقق إن كان المستخدم قد كتب تقييمًا مسبقًا لهذا النشاط
        $existingReview = Review::where('business_id', $request->business_id)
                                ->where('user_id', auth()->id())
                                ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'error' => ['message' => 'لقد قمت بالفعل بكتابة تقييم لهذا النشاط.']
            ], 422);
        }

        // إنشاء التقييم الجديد
        $review = Review::create([
            'user_id' => auth()->id(),
            'business_id' => $request->business_id,
            'rating' => $request->rating,
            'message' => $request->message,
            'is_approved' => 1,
        ]);

        return response()->json([
            'success' => true,
            'review' => $review->load('user'),
        ]);
    }


    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string|max:1000', // الحقل الصحيح هنا
        ]);

        $review->update([
            'message' => $request->message,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $review = Review::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $review->delete();
        return response()->json(['success' => true]);
    }

    public function getMore($businessId, $offset = 0)
    { 
        $reviews = Review::where('business_id', $businessId)
                        ->where('is_approved', 1)
                        ->with('user')
                        ->latest()
                        ->skip($offset * 3)
                        ->take(3)
                        ->get()
                        ->map(function ($rev) {
                            return [
                                'id'    => $rev->id,
                                'rating'=> $rev->rating,
                                'message' => $rev->message,
                                'dat' => $rev->created_at->format('d M Y'),
                                'user' => [
                                    'id'    => $rev->user->id,
                                    'name'  => $rev->user->name,
                                    // ✅ هنا نضع منطق الصورة الذكية:
                                    'resize' => Str::startsWith($rev->user->profile_photo, 'http')
                                        ? $rev->user->profile_photo
                                        : ($rev->user->profile_photo
                                            ? asset('storage/' . $rev->user->profile_photo)
                                            : asset('storage/profile-photos/default.webp')),
                                ],
                            ];
                        });

        // ✅ نضيف حساب المتوسط وعدد التقييمات بشكل منفصل دون التأثير على ما سبق
        $allApproved = Review::where('business_id', $businessId)
                            ->where('is_approved', 1);

        $average = round($allApproved->avg('rating'), 1);
        $count = $allApproved->count();

        return response()->json([
            'reviews' => $reviews,
            'average' => $average,
            'count' => $count,
        ]);
    }

}
