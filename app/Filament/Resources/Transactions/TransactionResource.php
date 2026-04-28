<?php

namespace App\Filament\Resources\Transactions;

use App\Filament\Resources\Transactions\Pages\ManageTransactions;
use App\Models\Transaction;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use UnitEnum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|UnitEnum|null $navigationGroup = '4. Bookings & Finance';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('booking_id')
                    ->relationship('booking', 'pnr_code')
                    ->required()
                    ->searchable()
                    ->label('Booking (PNR)'),

                Select::make('type')
                    ->options([
                        'payment' => 'Payment',
                        'refund' => 'Refund',
                        'stripe_fee' => 'Stripe Fee',
                        'cancellation_fee' => 'Cancellation Fee',
                    ])
                    ->required(),

                TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->prefix('$'),

                Textarea::make('description')
                    ->columnSpanFull()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking.pnr_code')
                    ->label('Associated PNR(s)') // Labelnya diganti dikit biar lebih pas
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    // 👇 TAMBAHKAN DESKRIPSI INI BUAT NGECEK TIKET RETURN
                    ->description(function ($record) {
                        // Cari apakah booking ini punya anak (Return Flight)
                        $childBooking = \App\Models\Booking::where('parent_booking_id', $record->booking_id)->first();

                        if ($childBooking) {
                            return 'Includes Return: ' . $childBooking->pnr_code;
                        }

                        return 'One-Way Ticket';
                    }),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
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
                    ->wrap()
                    ->searchable()
                    ->toggleable(),

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
