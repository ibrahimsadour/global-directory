<?php

namespace App\Filament\Widgets;

use App\Models\Business;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use App\Models\Governorate;
use App\Models\Location;
use App\Models\Category;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('عدد المحافظات', Governorate::count())
            ->description('إجمالي المحافظات المسجلة')
            ->color('primary'),

            Stat::make('عدد المدن / المناطق', Location::count())
                ->description('إجمالي المدن / المناطق')
                ->color('secondary'),

            Stat::make('عدد الفئات', Category::count())
                ->description('إجمالي الفئات المتاحة')
                ->color('success'),

            Stat::make('عدد الأنشطة', Business::count())
                ->description('جميع الأنشطة المسجلة')
                ->color('success'),

            Stat::make('عدد الأنشطة غير مقبولة', Business::where('is_approved', false)->count())
                ->description('في انتظار الموافقة')
                ->color('danger'),

            Stat::make('عدد الأنشطة المميزة', Business::where('is_featured', true)->count())
                ->description('أنشطة مميزة في القائمة')
                ->color('warning'),

            Stat::make('عدد المستخدمين الجدد هذا الشهر', User::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count())
                ->description('المستخدمون الجدد في هذا الشهر')
                ->color('info'),
        ];
    }
}
