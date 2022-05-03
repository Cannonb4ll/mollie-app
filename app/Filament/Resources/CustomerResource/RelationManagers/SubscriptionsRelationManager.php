<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class SubscriptionsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'subscriptions';

    protected static ?string $recordTitleAttribute = 'subscription_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subscription_id')->label('ID'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary',
                        'primary' => fn($state): bool => $state === 'cancelled',
                        'warning' => fn($state): bool => $state === 'pending',
                        'success' => fn($state): bool => $state === 'active',
                    ]),
                Tables\Columns\TextColumn::make('total')->money(function ($record) {
                    return $record->currency;
                }),
                Tables\Columns\TextColumn::make('description')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Date')
            ])
            ->filters([
                //
            ]);
    }
}
