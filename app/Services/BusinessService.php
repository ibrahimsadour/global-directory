<?php

namespace App\Services;

use App\Repositories\BusinessRepository;
use Illuminate\Support\Str;

class BusinessService
{
    protected $repository;

    public function __construct(BusinessRepository $repository)
    {
        $this->repository = $repository;
    }

    // عرض الاعلانات التي ذات صلة + بيانات السيو
    public function showBusinessWithRelated($slug)
    {
        $business = $this->repository->findActiveApprovedBySlug($slug);

        if (!$business) {
            abort(404);
        }

        $related = $this->repository->related($business);

        // إضافة بيانات السيو مع حماية كاملة
        $seoData = $this->getSeoData($business);

        return array_merge(
            compact('business', 'related'),
            $seoData
        );
    }

    // دالة لجلب بيانات السيو بشكل آمن
    public function getSeoData($business)
    {
        $seo = $business->seo;

        return [
            'seo_title' => $seo && !empty(trim($seo->meta_title)) ? $seo->meta_title : $business->name,
            'seo_description' => $seo && !empty(trim($seo->meta_description))
                ? $seo->meta_description
                : Str::limit(strip_tags($business->description), 150),
            'seo_keywords' => $seo && !empty(trim($seo->meta_keywords)) ? $seo->meta_keywords : '',
            'seo_image' => $seo && !empty($seo->meta_image)
                ? asset('storage/' . $seo->meta_image)
                : ($business->image
                    ? asset('storage/' . $business->image)
                    : asset('storage/site-settings/default-banner.webp')),
        ];
    }

    // لجلب الاعلانات المميزة
    public function getFeaturedBusinesses($limit = 8)
    {
        return $this->repository->getFeaturedBusinesses($limit);
    }

    // لجلب اخر 10 اعلانات تمت اضافتها
    public function getLatestBusinesses($limit = 10)
    {
        return $this->repository->getLatestBusinesses($limit);
    }
}
