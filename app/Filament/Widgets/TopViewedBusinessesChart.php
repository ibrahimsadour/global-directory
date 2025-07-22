<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class TopViewedBusinessesChart extends ChartWidget
{
    protected static ?string $heading = 'أعلى النشاطات مشاهدة (آخر 7 أيام)';

    protected function getData(): array
    {
        $views = DB::table('business_views')
            ->join('businesses', 'business_views.business_id', '=', 'businesses.id')
            ->select('businesses.name', DB::raw('COUNT(business_views.id) as views'))
            ->where('business_views.viewed_at', '>=', now()->subDays(7))
            ->groupBy('businesses.id', 'businesses.name')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'عدد المشاهدات',
                    'data' => $views->pluck('views'),
                ],
            ],
            'labels' => $views->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
