<?php

namespace App\Filament\Resources\Aircraft\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class AircraftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('model_name')->required(),
                TextInput::make('manufacturer'),
                TextInput::make('max_range_km')->numeric()->suffix('km'),
                TextInput::make('cruising_speed_kmh')->numeric()->suffix('km/h'),
                TextInput::make('engine_type'),
                Textarea::make('description')->columnSpanFull(),

                Fieldset::make('Seat Layout')
                    ->statePath('seat_layout')
                    ->schema([
                        TextInput::make('config')->placeholder('e.g. 3-4-3')->required(),
                        TextInput::make('rows')->numeric()->required(),
                        TextInput::make('business_rows')->numeric()->default(0),
                        TextInput::make('first_class_rows')->numeric()->default(0),
                        TagsInput::make('exit_rows')->placeholder('Hit Enter to add row (e.g. 15, 28)'),
                    ])->columns(3),
            ]);
    }
}
