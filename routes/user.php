<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\BusinessController;
use App\Http\Controllers\Auth\SocialController;


// Route::middleware(['web', 'auth', 'regular'])
//     ->prefix('user')
//     ->name('user.')
//     ->group(function () {
//         Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
//     });


Route::prefix('user')->name('user.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/my-business', [DashboardController::class, 'business'])->name('my-business');

    // اعدادت الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // إعدادات الحساب لتغيير كلمة المرور
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::post('/settings/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // الأنشطة التجارية
    Route::get('/business/create', [BusinessController::class, 'create'])->name('business.create'); // نموذج الإضافة
    Route::post('/business', [BusinessController::class, 'store'])->name('business.store');        // حفظ البيانات

    Route::get('/business/{id}/edit', [BusinessController::class, 'edit'])->name('business.edit'); // نموذج التعديل
    Route::put('/business/{id}', [BusinessController::class, 'update'])->name('business.update');  // تعديل البيانات

    Route::delete('/business/{id}', [BusinessController::class, 'destroy'])->name('business.destroy'); // حذف النشاط

    Route::get('/business/{id}', [BusinessController::class, 'show'])->name('business.show'); // عرض التفاصيل (اختياري)    

});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// });


Route::get('/auth/{provider}', [SocialController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialController::class, 'callback'])->name('social.callback');



require __DIR__.'/auth.php';
