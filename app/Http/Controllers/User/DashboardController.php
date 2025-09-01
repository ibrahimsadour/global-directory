<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // عدد الإعلانات النشطة
        $activeBusinesses = Business::where('user_id', $user->id)
            ->where('is_active', 1)
            ->count();

        // مجموع التقييمات (لكل إعلاناته)
        $totalReviews = Business::where('user_id', $user->id)
            ->withCount('reviews')
            ->get()
            ->sum('reviews_count');

        // آخر 3 إعلانات
        $latestBusinesses = Business::where('user_id', $user->id)
            ->with(['governorate', 'location'])
            ->latest()
            ->take(3)
            ->get();

        return view('user.dashboard', compact(
            'activeBusinesses',
            'totalReviews',
            'latestBusinesses'
        ));
    }



    public function business()
    {
        return view('user.my_business');
    }
}
