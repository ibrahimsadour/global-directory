<?php

namespace App\Filament\Widgets;

use App\Models\Business;
use App\Models\User;
use App\Models\Governorate;
use App\Models\Location;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\Review;
use Filament\Tables\Actions\Action;
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
            ->color('primary')
            ->url(route('filament.admin.resources.governorates.index'))
            ->extraAttributes([
            'class' => 'border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm',]),
            
        Stat::make('عدد المدن / المناطق', Location::count())
            ->description('إجمالي المدن والمناطق')
            ->icon('heroicon-o-building-office')
            ->color('secondary')
            ->url(route('filament.admin.resources.locations.index'))
            ->extraAttributes([
            'class' => 'border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm',]),

        Stat::make('عدد الفئات', Category::count())
            ->description('إجمالي الفئات المتاحة')
            ->icon('heroicon-o-rectangle-group')
            ->color('success')
            ->url(route('filament.admin.resources.categories.index'))
            ->extraAttributes([
            'class' => 'border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm',]),

        Stat::make('عدد الأنشطة', Business::count())
            ->description('جميع الأنشطة المسجلة')
            ->icon('heroicon-o-briefcase')
            ->color('info')
            ->url(route('filament.admin.resources.businesses.index'))
            ->extraAttributes([
            'class' => 'border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm',]),

        Stat::make('أنشطة غير مقبولة', Business::where('is_approved', false)->count())
            ->description('في انتظار الموافقة')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->url(route('filament.admin.resources.businesses.index', ['tableFilters[is_approved]' => '0']))
            ->extraAttributes([
            'class' => 'border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm',]),

        Stat::make('الأنشطة المميزة', Business::where('is_featured', true)->count())
            ->description('مميزة في الواجهة')
            ->icon('heroicon-o-star')
            ->color('warning')
            ->url(route('filament.admin.resources.businesses.index'))
            ->extraAttributes([
            'class' => 'border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm',]),

        Stat::make('مستخدمون جدد هذا الشهر', User::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count())
            ->description('عدد المستخدمين الجدد هذا الشهر')
            ->icon('heroicon-o-user-plus')
            ->color('primary')
            ->url(route('filament.admin.resources.users.index'))
            ->extraAttributes([
            'class' => 'border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm',]),

        Stat::make('عدد التقييمات', \App\Models\Review::count())
            ->description('إجمالي التقييمات المسجلة')
            ->icon('heroicon-o-chat-bubble-bottom-center-text')
            ->color('success')
            ->url(route('filament.admin.resources.reviews.index'))
            ->extraAttributes([
            'class' => 'border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm',]),

        ];
    }
}
