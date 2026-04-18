<?php

namespace App\Filament\Resources\Flights\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FlightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Flight Details')
                    ->schema([
                        TextInput::make('airline_code')
                            ->label('Airline Code (e.g., GA, SQ)')
                            ->required()
                            ->maxLength(3),
                        TextInput::make('flight_number')
                            ->label('Flight Number (e.g., GA-112)')
                            ->required()
                            ->maxLength(10),
                    ])->columns(2),

                Section::make('Route & Schedule')
                    ->schema([
                        TextInput::make('origin_airport')
                            ->label('Origin (IATA Code)')
                            ->required()
                            ->maxLength(3),
                        TextInput::make('destination_airport')
                            ->label('Destination (IATA Code)')
                            ->required()
                            ->maxLength(3),
                        DateTimePicker::make('departure_at')
                            ->required(),
                        DateTimePicker::make('arrival_at')
                            ->required(),
                    ])->columns(2),

                Section::make('Pricing')
                    ->schema([
                        TextInput::make('base_price_usd')
                            ->label('Base Price (USD)')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                    ])->columns(1),
            ]);
    }
}
