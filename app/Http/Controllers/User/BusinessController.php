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
            // أوقات العمل (لكل يوم)
            'hours' => 'nullable|array',
            'hours.*.day' => 'required|string|in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            'hours.*.open_time' => 'nullable|date_format:H:i',
            'hours.*.close_time' => 'nullable|date_format:H:i',

            // روابط التواصل
            'facebook'  => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter'   => 'nullable|url',
            'linkedin'  => 'nullable|url',
            'youtube'   => 'nullable|url',
            'tiktok'    => 'nullable|url',
        ]);

        // حفظ بالجلسة
        $business = session('business', []);
        $business['step3'] = $validated;
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
            $business = new Business();
            $business->fill($data);
            $business->user_id = Auth::id();

            // ✅ توليد slug
            $slug = Str::slug($data['name']);

            // ✅ تحقق إذا نفس المستخدم أضاف النشاط من قبل
            if (Business::where('slug', $slug)->where('user_id', Auth::id())->exists()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['name' => 'لقد قمت بإضافة هذا النشاط مسبقاً.']);
            }

            $business->slug = $slug;

            // ✅ الشعار
            if (!empty($data['image'])) {
                $business->image = $data['image'];
            }

            $business->save();

            // ✅ المعرض (اختياري)
            if (!empty($data['gallery'])) {
                foreach ($data['gallery'] as $file) {
                    // BusinessImage::create(['business_id' => $business->id, 'path' => $file]);
                }
            }

            session()->forget('business');

            return redirect()->route('user.dashboard')->with('success', 'تم حفظ النشاط بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['general' => 'حدث خطأ غير متوقع: ' . $e->getMessage()]);
        }
    }

}
