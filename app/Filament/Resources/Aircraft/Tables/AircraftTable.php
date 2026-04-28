<?php

namespace App\Filament\Resources\Aircraft\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AircraftTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('model_name')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->manufacturer),
                TextColumn::make('engine_type')->label('Engine'),
                TextColumn::make('max_range_km')
                    ->label('Range')
                    ->numeric()
                    ->suffix(' km')
                    ->sortable(),
                TextColumn::make('cruising_speed_kmh')
                    ->label('Speed')
                    ->numeric()
                    ->suffix(' km/h'),
            ])
            ->filters([
                SelectFilter::make('manufacturer')
                    ->options([
                        'Airbus' => 'Airbus',
                        'Boeing' => 'Boeing',
                    ]),
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
