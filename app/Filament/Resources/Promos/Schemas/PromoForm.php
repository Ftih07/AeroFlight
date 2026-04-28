<?php

namespace App\Filament\Resources\Promos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PromoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')->required()->unique(ignoreRecord: true),
                Select::make('discount_type')
                    ->options([
                        'percentage' => 'Percentage (%)',
                        'fixed' => 'Fixed Amount ($)'
                    ])->required(),
                TextInput::make('discount_value')->numeric()->required(),
                TextInput::make('quota')->numeric()->placeholder('Leave empty for unlimited'),
                DatePicker::make('valid_from'),
                DatePicker::make('valid_until'),
                Toggle::make('is_active')->default(true)->columnSpanFull(),
            ]);
    }
}
