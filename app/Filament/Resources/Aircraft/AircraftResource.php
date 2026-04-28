<?php

namespace App\Filament\Resources\Aircraft;

use App\Filament\Resources\Aircraft\Pages\CreateAircraft;
use App\Filament\Resources\Aircraft\Pages\EditAircraft;
use App\Filament\Resources\Aircraft\Pages\ListAircraft;
use App\Filament\Resources\Aircraft\Schemas\AircraftForm;
use App\Filament\Resources\Aircraft\Tables\AircraftTable;
use App\Models\Aircraft;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AircraftResource extends Resource
{
    protected static ?string $model = Aircraft::class;

    protected static string|UnitEnum|null $navigationGroup = '1. Aviation Master';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return AircraftForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AircraftTable::configure($table);
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
            'index' => ListAircraft::route('/'),
            'create' => CreateAircraft::route('/create'),
            'edit' => EditAircraft::route('/{record}/edit'),
        ];
    }
}
