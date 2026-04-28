<?php

namespace App\Filament\Resources\Airlines\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AirlineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')->required()->unique(ignoreRecord: true),
                TextInput::make('name')->required(),
                FileUpload::make('logo_path')->image()->directory('airlines')->disk('public'),
                TextInput::make('founded_year')->numeric(),
                TextInput::make('headquarters'),
                Textarea::make('description')->columnSpanFull(),
                // Trick Pivot: Langsung attach aircraft ke airline di form ini
                Select::make('aircrafts')
                    ->relationship('aircrafts', 'model_name')
                    ->multiple()
                    ->preload()
                    ->columnSpanFull(),
            ]);
    }
}
