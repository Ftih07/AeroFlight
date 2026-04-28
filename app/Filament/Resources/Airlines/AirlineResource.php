<?php

namespace App\Filament\Resources\Airlines;

use App\Filament\Resources\Airlines\Pages\CreateAirline;
use App\Filament\Resources\Airlines\Pages\EditAirline;
use App\Filament\Resources\Airlines\Pages\ListAirlines;
use App\Filament\Resources\Airlines\Schemas\AirlineForm;
use App\Filament\Resources\Airlines\Tables\AirlinesTable;
use App\Models\Airline;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class AirlineResource extends Resource
{
    protected static ?string $model = Airline::class;

    protected static string|UnitEnum|null $navigationGroup = '1. Aviation Master';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return AirlineForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AirlinesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAirlines::route('/'),
            'create' => CreateAirline::route('/create'),
            'edit' => EditAirline::route('/{record}/edit'),
        ];
    }
}
