<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use SebastiaanKloos\FilamentCodeEditor\Components\CodeEditor;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->helperText('The full name of the customer.'),
                Forms\Components\TextInput::make('email')->email()->helperText('The email address of the customer.'),
                Forms\Components\Select::make('locale')
                    ->helperText('Allows you to preset the language to be used in the hosted payment pages shown to the consumer. When this parameter is not provided, the browser language will be used instead in the payment flow (which is usually more accurate).')
                    ->options([
                    'en_US' => 'en_US',
                    'en_GB' => 'en_GB',
                    'nl_NL' => 'nl_NL',
                    'nl_BE' => 'nl_BE',
                    'fr_FR' => 'fr_FR',
                    'fr_BE' => 'fr_BE',
                    'de_DE' => 'de_DE',
                    'de_AT' => 'de_AT',
                    'de_CH' => 'de_CH',
                    'es_ES' => 'es_ES',
                    'ca_ES' => 'ca_ES',
                    'pt_PT' => 'pt_PT',
                    'it_IT' => 'it_IT',
                    'nb_NO' => 'nb_NO',
                    'sv_SE' => 'sv_SE',
                    'fi_FI' => 'fi_FI',
                    'da_DK' => 'da_DK',
                    'is_IS' => 'is_IS',
                    'hu_HU' => 'hu_HU',
                    'pl_PL' => 'pl_PL',
                    'lv_LV' => 'lv_LV',
                    'lt_LT' => 'lt_LT',
                ]),

                Forms\Components\Card::make()->columnSpan(1)->schema([
                    CodeEditor::make('metadata')
                        ->helperText('Provide any data you like, and we will save the data alongside the customer. Whenever you fetch the customer with our API, we will also include the metadata. You can use up to 1kB of JSON.'),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_id')->searchable()->label('ID'),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('locale'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Date')
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TransactionsRelationManager::class,
            RelationManagers\SubscriptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
