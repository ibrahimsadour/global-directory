<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\BusinessController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\User\ReviewController;


// Route::middleware(['web', 'auth', 'regular'])
//     ->prefix('user')
//     ->name('user.')
//     ->group(function () {
//         Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
//     });


Route::prefix('user')->name('user.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-business', [DashboardController::class, 'business'])->name('my-business');

    // الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // إعدادات الحساب
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::post('/settings/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // 🔹 خطوات إضافة النشاط التجاري (Wizard)
    Route::prefix('business')->name('business.')->group(function () {
        Route::get('/create', fn() => redirect()->route('user.business.step1'))->name('create');

        Route::get('/step1', [BusinessController::class, 'step1'])->name('step1');
        Route::post('/step1', [BusinessController::class, 'step1Store'])->name('step1.store');

        Route::get('/step2', [BusinessController::class, 'step2'])->name('step2');
        Route::post('/step2', [BusinessController::class, 'step2Store'])->name('step2.store');

        Route::get('/step3', [BusinessController::class, 'step3'])->name('step3');
        Route::post('/step3', [BusinessController::class, 'step3Store'])->name('step3.store');
        // ... تكمل باقي الخطوات بنفس النمط
        Route::get('/finish', [BusinessController::class, 'finish'])->name('finish');

        // CRUD الأساسي (لو حبيت تخليهم برضو)
        // Route::post('/', [BusinessController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BusinessController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BusinessController::class, 'update'])->name('update');
        Route::delete('/{id}', [BusinessController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [BusinessController::class, 'show'])->name('show');
    });
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// });


Route::get('auth/google', [SocialController::class, 'redirectGoogle'])->name('social.redirect.google');
Route::get('auth/google/callback', [SocialController::class, 'callbackGoogle']);

Route::get('auth/twitter', [SocialController::class, 'redirectTwitter'])->name('social.redirect.twitter');
Route::get('auth/twitter/callback', [SocialController::class, 'callbackTwitter']);

Route::get('auth/facebook', [SocialController::class, 'redirectFacebook'])->name('social.redirect.facebook');
Route::get('auth/facebook/callback', [SocialController::class, 'callbackFacebook']);



Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::post('/rating', [ReviewController::class, 'store']);
    Route::put('/updaterating/{review}', [ReviewController::class, 'update']);
    Route::delete('/deleterating/{review}', [ReviewController::class, 'destroy']);
});
Route::get('/getMoreReviews/{id}/{offset?}', [ReviewController::class, 'getMore']);

require __DIR__.'/auth.php';
