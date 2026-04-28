<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Booking;
use Carbon\Carbon;

class MonthlyBookingsChart extends ChartWidget
{
    // HAPUS kata 'static' di sini
    protected ?string $heading = 'Monthly Bookings (This Year)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $months = [];
        $year = now()->year;

        for ($i = 1; $i <= 12; $i++) {
            $months[] = \Carbon\Carbon::createFromDate($year, $i, 1)->shortMonthName;

            $data[] = Booking::whereYear('created_at', $year)
                ->whereMonth('created_at', $i)
                // Tambahkan 'paid' di sini
                ->whereIn('status', ['paid', 'confirmed', 'used'])
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Valid Bookings',
                    'data' => $data,
                    'fill' => 'start',
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#3b82f6',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
