<?php

namespace App\Filament\Resources\Transactions;

use App\Filament\Resources\Transactions\Pages\ManageTransactions;
use App\Models\Transaction;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking.pnr_code')
                    ->label('PNR Code')
                    ->searchable()
                    ->sortable()
                    ->copyable(), // Biar gampang dicopy admin
                
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'payment' => 'success',
                        'refund' => 'danger',
                        'stripe_fee' => 'warning',
                        'cancellation_fee' => 'info',
                        default => 'gray',
                    }),
                
                TextColumn::make('amount')
                    ->money('USD')
                    ->sortable(),
                
                TextColumn::make('description')
                    ->wrap() // Wrap agar teks panjang tidak terpotong
                    ->searchable(),
                
                TextColumn::make('created_at')
                    ->label('Transaction Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // Filter bawaan Filament berdasarkan Tipe Transaksi
                SelectFilter::make('type')
                    ->options([
                        'payment' => 'Payment',
                        'refund' => 'Refund',
                        'stripe_fee' => 'Stripe Fee',
                        'cancellation_fee' => 'Cancellation Fee',
                    ]),
            ])
            ->actions([])
            ->bulkActions([])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTransactions::route('/'),
        ];
    }
}
