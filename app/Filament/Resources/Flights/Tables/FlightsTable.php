<?php

namespace App\Filament\Resources\Flights\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FlightsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('airline_code')
                    ->label('Airline')
                    ->searchable(),
                TextColumn::make('flight_number')
                    ->searchable(),
                TextColumn::make('origin_airport')
                    ->label('Origin')
                    ->searchable(),
                TextColumn::make('destination_airport')
                    ->label('Destination')
                    ->searchable(),
                TextColumn::make('departure_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('base_price_usd')
                    ->label('Price')
                    ->money('USD')
                    ->sortable(),
            ])
            ->filters([
                //
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
