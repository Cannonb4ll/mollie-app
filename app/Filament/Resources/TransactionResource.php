<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Payments';

    protected static ?string $recordTitleAttribute = 'payment_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')->maxLength(255)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_id')->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary',
                        'primary' => fn ($state): bool => $state === 'expired',
                        'warning' => fn ($state): bool => $state === 'pending',
                        'success' => fn ($state): bool => $state === 'paid',
                    ]),
                Tables\Columns\TextColumn::make('total')->money(function ($record) {
                    return $record->currency;
                }),
                Tables\Columns\TextColumn::make('description')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Date')
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
