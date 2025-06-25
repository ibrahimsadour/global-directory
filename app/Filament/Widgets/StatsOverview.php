<?php

namespace App\Filament\Widgets;

use App\Models\Business;
use App\Models\User;
use App\Models\Governorate;
use App\Models\Location;
use App\Models\Category;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full'; // لعرض البطاقات بعرض الصفحة

    protected function getStats(): array
    {
        return [
            Stat::make('عدد المحافظات', Governorate::count())
                ->description('إجمالي المحافظات المسجلة')
                ->icon('heroicon-o-map')
                ->color('primary'),

            Stat::make('عدد المدن / المناطق', Location::count())
                ->description('إجمالي المدن والمناطق')
                ->icon('heroicon-o-building-office')
                ->color('secondary'),

            Stat::make('عدد الفئات', Category::count())
                ->description('إجمالي الفئات المتاحة')
                ->icon('heroicon-o-rectangle-group')
                ->color('success'),

            Stat::make('عدد الأنشطة', Business::count())
                ->description('جميع الأنشطة المسجلة')
                ->icon('heroicon-o-briefcase')
                ->color('info'),

            Stat::make('أنشطة غير مقبولة', Business::where('is_approved', false)->count())
                ->description('في انتظار الموافقة')
                ->icon('heroicon-o-x-circle')
                ->color('danger'),

            Stat::make('الأنشطة المميزة', Business::where('is_featured', true)->count())
                ->description('مميزة في الواجهة')
                ->icon('heroicon-o-star')
                ->color('warning'),

            Stat::make('مستخدمون جدد هذا الشهر', User::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count())
                ->description('عدد المستخدمين الجدد هذا الشهر')
                ->icon('heroicon-o-user-plus')
                ->color('primary'),
        ];
    }
}
