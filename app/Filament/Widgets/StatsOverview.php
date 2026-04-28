<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Flight;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    // Supaya posisinya paling atas
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Tambahkan 'paid' ke dalam pencarian revenue
        $revenue = Booking::whereIn('status', ['paid', 'confirmed', 'used'])->sum('final_amount_usd');

        // Tambahkan 'paid' ke active bookings
        $activeBookings = Booking::whereIn('status', ['paid', 'confirmed'])->count();

        $refundRequests = Booking::where('status', 'refund_requested')->count();
        $todaysFlights = Flight::whereDate('departure_at', \Carbon\Carbon::today())->count();

        return [
            Stat::make('Total Revenue', '$' . number_format($revenue, 2))
                ->description('From paid, confirmed & used tickets')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Active Bookings', $activeBookings)
                ->description('Awaiting departure schedule')
                ->color('info'),

            Stat::make('Refund Requests', $refundRequests)
                ->description($refundRequests > 0 ? 'Requires immediate attention!' : 'Under control')
                ->descriptionIcon($refundRequests > 0 ? 'heroicon-m-exclamation-circle' : 'heroicon-m-check-circle')
                ->color($refundRequests > 0 ? 'danger' : 'success'),

            Stat::make('Today\'s Flights', $todaysFlights)
                ->description('Flights departing today')
                ->color('primary'),
        ];
    }
}
