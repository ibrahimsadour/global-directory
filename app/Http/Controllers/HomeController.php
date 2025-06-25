<?php

namespace App\Http\Controllers;
use App\Services\GovernorateService;
use App\Services\CategoryService;
use App\Services\LocationService;
use App\Services\BusinessService;

class HomeController extends Controller
{
    protected $categoryService;
    protected $locationService;
    protected $governorateService;
    protected $businessService;


public function __construct(
    CategoryService $categoryService,
    LocationService $locationService,
    GovernorateService $governorateService,
    BusinessService $businessService 
) {
    $this->categoryService = $categoryService;
    $this->locationService = $locationService;
    $this->governorateService = $governorateService;
    $this->businessService = $businessService;
}


    public function index()
    {
        $categories = $this->categoryService->getCategoriesForHome();
        $locations = $this->locationService->getAllLocations(); // نستخدمه لاحقاً إن أحببت
        $governorates = $this->governorateService->getAllGovernorates();
        $featuredBusinesses = $this->businessService->getFeaturedBusinesses();
        $latestBusinesses = $this->businessService->getLatestBusinesses();



        return view('home', compact('categories', 'governorates', 'featuredBusinesses', 'latestBusinesses'));
    }
}
