<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\Governorate;
class LocationController extends Controller
{

    public function show($slug)
    {
        // 1. جلب المدينة مع المحافظة التابعة لها
        $location = Location::with('governorate:id,name,slug')
            ->where('slug', $slug)
            ->select('id', 'area', 'slug', 'governorate_id')
            ->firstOrFail();

        // 2. جلب الإعلانات النشطة والمقبولة الخاصة بهذه المدينة
        $businesses = Business::where('location_id', $location->id)
            ->where('is_active', 1)
            ->where('is_approved', 1)
            ->select('id', 'name', 'slug', 'image', 'description')
            ->latest()
            ->paginate(15);

        // 3. جلب جميع المحافظات للقائمة الجانبية
        $governorates = Governorate::select('id', 'name', 'slug')
            ->orderBy('name')
            ->get();

        return view('locations.show', [
            'location' => $location,
            'businesses' => $businesses,
            'governorates' => $governorates,
        ]);
    }

}
