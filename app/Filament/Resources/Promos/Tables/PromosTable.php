<?php

namespace App\Filament\Resources\Promos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PromosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),
                TextColumn::make('discount_value')
                    ->label('Value')
                    ->formatStateUsing(
                        fn($record, $state) =>
                        $record->discount_type === 'percentage' ? "{$state}%" : "$ {$state}"
                    ),
                TextColumn::make('quota')
                    ->label('Remaining')
                    ->formatStateUsing(fn($state) => $state ?? 'Unlimited'),
                TextColumn::make('valid_until')
                    ->label('Expiry')
                    ->date()
                    ->sortable()
                    ->color(fn($state) => \Carbon\Carbon::parse($state)->isPast() ? 'danger' : 'success'),
                ToggleColumn::make('is_active'),
            ])
            ->filters([
               TernaryFilter::make('is_active'),
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
