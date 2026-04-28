<?php

namespace App\Filament\Resources\Flights\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FlightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Info')->schema([
                    Select::make('provider')
                        ->options(['internal' => 'Internal', 'duffel' => 'Duffel'])
                        ->default('internal'),
                    TextInput::make('provider_flight_id'),
                    TextInput::make('origin_airport')->required()->maxLength(3),
                    TextInput::make('destination_airport')->required()->maxLength(3),
                    DateTimePicker::make('departure_at')->required(),
                    DateTimePicker::make('arrival_at')->required(),
                    TextInput::make('stop_count')->numeric()->default(0),
                ])->columns(2),

                Section::make('Refund Policy')->schema([
                    Toggle::make('is_refundable')->inline(false),
                    Textarea::make('policy_notes')->columnSpanFull(),
                ])->columns(2),
            ]);
    }
}
