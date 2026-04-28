<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class LatestBookings extends BaseWidget
{
    protected int | string | array $columnSpan = 'full'; // Biar lebarnya full screen
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Ambil 5 booking paling baru
                Booking::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('pnr_code')
                    ->label('PNR')
                    ->weight('bold')
                    ->copyable(),
                TextColumn::make('user.name')
                    ->label('Customer'),
                TextColumn::make('flight.provider_flight_id')
                    ->label('Flight ID'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'awaiting_payment' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'used' => 'info',
                        'refund_requested' => 'warning',
                        'refunded' => 'danger',
                        'expired' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('final_amount_usd')
                    ->label('Total Paid')
                    ->money('USD'),
                TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated(false); // Matiin pagination biar ringkas
    }
}