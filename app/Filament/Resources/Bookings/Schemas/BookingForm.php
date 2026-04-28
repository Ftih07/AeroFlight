<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Booking Details')->schema([
                    TextInput::make('id')->label('Booking UUID')->disabled(),
                    Select::make('user_id')->relationship('user', 'name')->searchable()->disabled(),
                    Select::make('flight_id')->relationship('flight', 'provider_flight_id')->disabled(),
                    TextInput::make('pnr_code')->disabled(),
                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'awaiting_payment' => 'Awaiting Payment',
                            'confirmed' => 'Confirmed',
                            'cancelled' => 'Cancelled'
                        ])->required(),
                ])->columns(2),

                Section::make('Financial Snapshot (Read-Only)')->schema([
                    TextInput::make('total_amount_usd')->numeric()->prefix('$')->disabled(),
                    TextInput::make('discount_amount_usd')->numeric()->prefix('$')->disabled(),
                    TextInput::make('insurance_fee_usd')->numeric()->prefix('$')->disabled(),
                    TextInput::make('final_amount_usd')->numeric()->prefix('$')->disabled(),
                ])->columns(2),
            ]);
    }
}
