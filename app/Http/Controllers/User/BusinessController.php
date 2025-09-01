<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\BusinessHour;
use App\Models\BusinessSocialLink;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\CategoryService;
use App\Services\LocationService;
use App\Services\GovernorateService;

class BusinessController extends Controller
{
    protected $categoryService;
    protected $locationService;
    protected $governorateService;

    public function __construct(
        CategoryService $categoryService,
        LocationService $locationService,
        GovernorateService $governorateService
    ) {
        $this->categoryService = $categoryService;
        $this->locationService = $locationService;
        $this->governorateService = $governorateService;
    }

    /**
     * ============= STEP 1: البيانات الأساسية =============
     */
    public function step1()
    {
        $categories = $this->categoryService->getCategoriesForHome();
        $governorates = $this->governorateService->getAllGovernorates();
        $data = session('business', []);

        return view('user.business.step1', compact('categories', 'governorates', 'data'));
    }

    public function step1Store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'governorate_id' => 'required|exists:governorates,id',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'whatsapp' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        session()->put('business', array_merge(session('business', []), $validated));

        return redirect()->route('user.business.step2');
    }

    /**
     * ============= STEP 2: رفع الشعار والمعرض =============
     */
    public function step2()
    {
        $data = session('business', []);
        return view('user.business.step2', compact('data'));
    }

    public function step2Store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('temp/business/images', 'public');
            $validated['image'] = $path;
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('temp/business/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        }

        session()->put('business', array_merge(session('business', []), $validated));

        return redirect()->route('user.business.step3');
    }

    /**
     * ============= STEP 3: أوقات الدوام + روابط التواصل =============
     */
    public function step3()
    {
        $business = session('business', []);
        return view('user.business.step3', compact('business'));
    }

    public function step3Store(Request $request)
    {
        $validated = $request->validate([
            'hours' => 'nullable|array',
            'hours.*.day' => 'required|string|in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            'hours.*.open_hour' => 'nullable|integer',
            'hours.*.open_period' => 'nullable|in:AM,PM',
            'hours.*.close_hour' => 'nullable|integer',
            'hours.*.close_period' => 'nullable|in:AM,PM',

            'facebook'  => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter'   => 'nullable|url',
            'linkedin'  => 'nullable|url',
            'youtube'   => 'nullable|url',
            'tiktok'    => 'nullable|url',
        ]);

        // معالجة ساعات العمل وتحويلها إلى open_time/close_time
        $hours = [];
        if (!empty($validated['hours'])) {
            foreach ($validated['hours'] as $row) {
                if (!empty($row['open_hour']) && !empty($row['close_hour'])) {
                    $open_time  = $row['open_hour'] . ':00 ' . $row['open_period'];   // مثال: 9:00 AM
                    $close_time = $row['close_hour'] . ':00 ' . $row['close_period']; // مثال: 5:00 PM

                    $hours[] = [
                        'day' => $row['day'],
                        'open_time' => date('H:i', strtotime($open_time)),
                        'close_time' => date('H:i', strtotime($close_time)),
                    ];
                }
            }
        }

        // روابط التواصل
        $socialLinks = $request->only(['facebook','instagram','twitter','linkedin','youtube','tiktok']);

        // حفظ بالجلسة
        $business = session('business', []);
        $business['hours'] = $hours;
        $business['social_links'] = $socialLinks;
        session(['business' => $business]);

        return redirect()->route('user.business.finish');
    }


    /**
     * ============= FINISH: إنهاء وحفظ النشاط =============
     */
    public function finish()
    {
        $data = session('business', []);

        if (empty($data)) {
            return redirect()->route('user.business.step1')
                ->withErrors(['general' => 'لم يتم إدخال بيانات النشاط.']);
        }

        try {
            // إنشاء النشاط
            $business = new Business();
            $business->fill([
                'user_id'       => Auth::id(),
                'category_id'   => $data['category_id'] ?? null,
                'location_id'   => $data['location_id'] ?? null,
                'governorate_id'=> $data['governorate_id'] ?? null,
                'name'          => $data['name'] ?? '',
                'description'   => $data['description'] ?? null,
                'phone'         => $data['phone'] ?? null,
                'email'         => $data['email'] ?? null,
                'website'       => $data['website'] ?? null,
                'whatsapp'      => $data['whatsapp'] ?? null,
                'address'       => $data['address'] ?? null,
                'image'         => $data['image'] ?? null,
                'gallery'       => !empty($data['gallery']) ? json_encode($data['gallery']) : null,
            ]);
            $business->slug = Str::slug($business->name);
            $business->save();

            // حفظ ساعات العمل
            if (!empty($data['hours'])) {
                foreach ($data['hours'] as $row) {
                    BusinessHour::create([
                        'business_id' => $business->id,
                        'day'         => $row['day'],
                        'open_time'   => $row['open_time'],
                        'close_time'  => $row['close_time'],
                    ]);
                }
            }

            // حفظ روابط التواصل
            if (!empty($data['social_links'])) {
                BusinessSocialLink::create(array_merge(
                    ['business_id' => $business->id],
                    $data['social_links']
                ));
            }

            // تفريغ السيشن
            session()->forget('business');

            return redirect()->route('user.dashboard')->with('success', 'تم حفظ النشاط بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['general' => 'حدث خطأ غير متوقع: ' . $e->getMessage()]);
        }
    }


}
