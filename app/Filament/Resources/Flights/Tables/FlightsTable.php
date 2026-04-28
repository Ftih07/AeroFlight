<?php

namespace App\Filament\Resources\Flights\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class FlightsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('provider_flight_id')
                    ->label('Flight ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('route')
                    ->label('Route')
                    ->state(fn($record) => "{$record->origin_airport} ➔ {$record->destination_airport}")
                    ->icon('heroicon-m-arrow-right-circle'),
                TextColumn::make('departure_at')
                    ->label('Departure')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                TextColumn::make('stop_count')
                    ->label('Stops')
                    ->badge()
                    ->color(fn($state) => $state === 0 ? 'success' : 'warning')
                    ->formatStateUsing(fn($state) => $state === 0 ? 'Direct' : "{$state} Transit"),
                IconColumn::make('is_refundable')
                    ->boolean()
                    ->label('Refundable'),
            ])
            ->filters([
                Filter::make('Direct Flights')
                    ->query(fn($query) => $query->where('stop_count', 0)),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
