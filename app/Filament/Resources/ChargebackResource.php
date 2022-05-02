<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChargebackResource\Pages;
use App\Filament\Resources\ChargebackResource\RelationManagers;
use App\Models\Chargeback;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ChargebackResource extends Resource
{
    protected static ?string $model = Chargeback::class;

    protected static ?string $navigationIcon = 'heroicon-o-rewind';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ]);
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
            'index' => Pages\ListChargebacks::route('/'),
            'create' => Pages\CreateChargeback::route('/create'),
            'edit' => Pages\EditChargeback::route('/{record}/edit'),
        ];
    }
}
