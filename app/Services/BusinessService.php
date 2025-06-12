<?php

namespace App\Services;

use App\Repositories\BusinessRepository;

class BusinessService
{
    protected $repository;

    public function __construct(BusinessRepository $repository)
    {
        $this->repository = $repository;
    }
    // عرض الاعلانات التي ذات صلة
    public function showBusinessWithRelated($slug)
    {
        $business = $this->repository->findActiveApprovedBySlug($slug);
        if (!$business) {
            abort(404);
        }
        $related = $this->repository->related($business);
        return compact('business', 'related');
    }
    // لجلب الاعللانات المميزة
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
