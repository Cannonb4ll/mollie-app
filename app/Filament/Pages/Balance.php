<?php

namespace App\Filament\Pages;

use Filament\Pages\Actions\ButtonAction;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class Balance extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.balance';

    public static string $balance = '';

    protected function getTableQuery(): Builder
    {
        return \App\Models\Balance::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('balance_id'),
            TextColumn::make('incoming')->money(function ($record) {
                return $record->currency;
            }),
            TextColumn::make('available')->money(function ($record) {
                return $record->currency;
            }),
            TextColumn::make('created_at')->dateTime()->sortable()->label('Date'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        $balance = Cache::remember('mollie-balance-sidebar', now()->addMinutes(10), function () {
            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setAccessToken(config('services.mollie.oauth'));
            return Arr::first($mollie
                ->performHttpCallToFullUrl(
                    'get',
                    'https://api.mollie.com/v2/balances'
                )
                ->_embedded->balances);
        });

        return money($balance->incomingAmount->value, $balance->incomingAmount->currency);
    }

    protected function getActions(): array
    {
        return [
            ButtonAction::make('refresh')->color('secondary')
                ->action(function () {
                    cache()->forget('mollie-balances');

                    $this->notify('success', 'Cache for balances have been cleared, you\'re seeing latest data.');
                })
                ->modalSubheading('Are you sure you want to clear the balances cache? This will gather the latest balances from Mollie via the API again. This is not a harmful action.')
                ->requiresConfirmation(),
        ];
    }
}
