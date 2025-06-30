<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\LocationController;
use App\Models\Location;
use App\Http\Controllers\User\SearchController;
use App\Models\Redirect;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/search', [SearchController::class, 'index'])->name('search');


Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/governorates', [GovernorateController::class, 'index'])->name('governorates.index');
Route::get('/governorates/{slug}', [GovernorateController::class, 'show'])->name('governorates.show');
Route::get('/locations/{slug}', [LocationController::class, 'show'])->name('locations.show');

Route::get('/business/{slug}', [BusinessController::class, 'show'])->name('business.show');


// Sitemap.xml
Route::get('/sitemap.xml', function () {
    return response()->view('sitemap.index')->header('Content-Type', 'application/xml');
});

Route::get('/sitemap-home.xml', function () {
    $sitemap = Sitemap::create();

    $sitemap->add(
        Url::create(url('/'))
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
    );

    return $sitemap->toResponse(request());
});

Route::get('/sitemap-categories.xml', function () {
    $sitemap = Sitemap::create();

    foreach (\App\Models\Category::all() as $category) {
        $sitemap->add(
            Url::create(route('categories.show', $category->slug))
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setLastModificationDate($category->updated_at)
        );
    }

    return $sitemap->toResponse(request());
});

Route::get('/sitemap-governorates.xml', function () {
    $sitemap = Sitemap::create();

    foreach (\App\Models\Governorate::all() as $governorate) {
        $sitemap->add(
            Url::create(route('governorates.show', $governorate->slug))
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setLastModificationDate($governorate->updated_at)
        );
    }

    return $sitemap->toResponse(request());
});

Route::get('/sitemap-locations.xml', function () {
    $sitemap = Sitemap::create();

    foreach (Location::all() as $location) {
        $sitemap->add(
            Url::create(route('locations.show', $location->slug))
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setLastModificationDate($location->updated_at)
        );
    }

    return $sitemap->toResponse(request());
});
Route::get('/sitemap-business.xml', function () {

    $sitemap = Sitemap::create();

    \App\Models\Business::where('is_active', true)
        ->where('is_approved', true)
        ->orderBy('id') // مهم: حتى لا تتكرر النتائج بين الـ chunks
        ->chunk(1000, function ($businesses) use ($sitemap) {

            foreach ($businesses as $business) {
                $sitemap->add(
                    Url::create(route('business.show', $business->slug))
                        ->setPriority(0.8)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setLastModificationDate($business->updated_at)
                );
            }

        });

    return $sitemap->toResponse(request());
});

// Robots.txt
Route::get('/robots.txt', function () {

    $defaultRobots = "User-agent: *\nAllow: /\nSitemap: " . url('/sitemap.xml');

    $robotsContent = setting('seo_robots_txt', $defaultRobots);

    return response($robotsContent, 200)
        ->header('Content-Type', 'text/plain');
});


