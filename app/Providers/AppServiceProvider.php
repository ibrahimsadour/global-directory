<?php

namespace App\Providers;
use App\Models\Category;
use App\Models\Governorate;
use Filament\Facades\Filament;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['components.head', 'components.footer'], function ($view) {
            $categories = Category::where('is_active', 1)->get();
            $governorates = Governorate::where('is_active', 1)->get();

            $view->with([
                'categories'   => $categories,
                'governorates' => $governorates,
            ]);
        });
    }
}
