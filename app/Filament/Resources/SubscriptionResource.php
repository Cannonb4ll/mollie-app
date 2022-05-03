<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Payments';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Card::make()
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('description')->columnSpan(1),
                        Forms\Components\TextInput::make('total')
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, $state) {
                                $component->state($state / 100);
                            })
                            ->numeric()
                            ->columnSpan(1),
                        Forms\Components\Select::make('currency')->options([
                            'EUR' => 'Euro',
                            'USD' => 'Dollar'
                        ]),
                        Forms\Components\TextInput::make('webhook_url')->columnSpan(2),
                    ])
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
