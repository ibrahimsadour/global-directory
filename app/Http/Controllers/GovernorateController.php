<?php

namespace App\Http\Controllers;

use App\Services\GovernorateService;
use Illuminate\View\View;
use App\Models\Business;
use App\Models\Governorate;

class GovernorateController extends Controller
{
    protected $governorateService;

    public function __construct(GovernorateService $governorateService)
    {
        $this->governorateService = $governorateService;
    }

    /**
     * عرض جميع المحافظات النشطة
     * 
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $governorates = $this->governorateService->getAllGovernorates();
        return view('governorate.index', compact('governorates'));
    }

    public function show($slug)
    {
        // 1. جلب المحافظة المطلوبة مع التحقق من وجودها
        $governorate = Governorate::where('slug', $slug)
            ->select('id', 'name', 'slug') // تحديد الحقول المطلوبة فقط
            ->firstOrFail();

        $locationIds = \App\Models\Location::where('governorate_id', $governorate->id)->pluck('id');

        // 2. جلب الإعلانات النشطة والمقبولة للمحافظة
        $businesses = Business::where(function ($query) use ($governorate, $locationIds) {
                $query->where('governorate_id', $governorate->id)
                    ->orWhereIn('location_id', $locationIds);
            })
            ->where('is_active', 1)
            ->where('is_approved', 1)
            ->select('id', 'name', 'slug', 'image', 'description')
            ->latest()
            ->paginate(10);

        // 3. جلب جميع المحافظات للقائمة الجانبية
        $governorates = Governorate::select('id', 'name', 'slug')
            ->orderBy('name')
            ->get();

        return view('governorate.show', [
            'governorate' => $governorate,
            'businesses' => $businesses,
            'governorates' => $governorates 
        ]);
    }
    
}