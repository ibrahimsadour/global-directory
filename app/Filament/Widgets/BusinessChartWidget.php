<?php

namespace App\Filament\Widgets;

use App\Models\Business;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class BusinessChartWidget extends ChartWidget
{
    protected static ?string $heading = 'تطور عدد الأنشطة بالشهور';

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');
            $data[] = Business::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'عدد الأنشطة',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
