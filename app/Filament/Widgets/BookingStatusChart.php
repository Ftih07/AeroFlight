<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Booking;

class BookingStatusChart extends ChartWidget
{
    // HAPUS kata 'static' di sini
    protected ?string $heading = 'Bookings by Status';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $statuses = Booking::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Bookings',
                    'data' => array_values($statuses),
                    'backgroundColor' => [
                        '#10B981', // emerald-500
                        '#3B82F6', // blue-500
                        '#F59E0B', // amber-500
                        '#EF4444', // red-500
                        '#6B7280', // gray-500
                    ],
                ],
            ],
            'labels' => array_keys($statuses),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
