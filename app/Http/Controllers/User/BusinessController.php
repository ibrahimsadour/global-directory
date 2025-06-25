<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Services\CategoryService;
use App\Services\LocationService;
use App\Services\GovernorateService;
use Illuminate\Database\QueryException;

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


    public function create()
    {
        $categories = $this->categoryService->getCategoriesForHome();
        $locations = []; // غير ضروري الآن لأننا سنستخدم governorates->locations
        $governorates = $this->governorateService->getAllGovernorates();

        return view('user.business.create', compact('categories', 'governorates'));

    }

    public function store(Request $request)
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
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $business = new Business($validated);
            $business->user_id = Auth::id();
            $business->slug = Str::slug($request->name);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('business/images', 'public');
                $business->image = $path;
            }

            $business->save();

            return redirect()->back()->with('success', 'تم حفظ النشاط بنجاح.');

        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                // خطأ تكرار
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['name' => 'تم استخدام هذا الاسم من قبل. الرجاء اختيار اسم مختلف.']);
            }

            // أخطاء أخرى
            return redirect()->back()
                ->withInput()
                ->withErrors(['general' => 'حدث خطأ غير متوقع. الرجاء المحاولة لاحقًا.']);
        }
    }

    public function edit($id)
    {
        $business = Business::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('business.edit', compact('business'));
    }

    public function update(Request $request, $id)
    {
        $business = Business::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

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
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $business->fill($validated);
        $business->slug = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($business->image) {
                Storage::disk('public')->delete($business->image);
            }
            $path = $request->file('image')->store('business/images', 'public');
            $business->image = $path;
        }

        $business->save();

        return redirect()->route('user.my-listings')->with('success', 'Business updated successfully.');
    }

    public function destroy($id)
    {
        $business = Business::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($business->image) {
            Storage::disk('public')->delete($business->image);
        }

        $business->delete();

        return redirect()->route('user.my-listings')->with('success', 'Business deleted successfully.');
    }

    public function show($id)
    {
        $business = Business::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('business.show', compact('business'));
    }
}
