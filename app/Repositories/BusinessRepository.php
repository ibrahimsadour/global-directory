<?php 
namespace App\Repositories;

use App\Models\Business;

class BusinessRepository
{
    public function findActiveApprovedBySlug($slug)
    {
        return Business::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_approved', true)
            ->first();
    }
    
    // عرض الاعلانات التي ذات صلة
    public function related($business, $limit = 4)
    {
        return Business::where('category_id', $business->category_id)
            ->where('id', '!=', $business->id)
            ->where('is_active', true)
            ->where('is_approved', true)
            ->latest()
            ->take($limit)
            ->get();
    }

    //  دالة لجلب الإعلانات المميزة داخل الريبوستري.
    public function getFeaturedBusinesses($perPage = 6)
    {
        return Business::where('is_active', 1)
            ->where('is_approved', 1)
            ->where('is_featured', 1)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    //  دالة لجلب ااخر الاعلانات داخل الريبوستري.
    public function getLatestBusinessesPaginated($perPage = 6)
    {
        return Business::where('is_active', 1)
            ->where('is_approved', 1)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
