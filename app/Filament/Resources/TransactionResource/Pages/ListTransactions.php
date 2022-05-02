<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getActions(): array
    {
        return [
            ButtonAction::make('refresh')->color('secondary')
                ->action(function() {
                    cache()->forget('mollie-transactions');

                    $this->notify('success', 'Cache for transactions have been cleared, you\'re seeing latest data.');
                })
                ->modalSubheading('Are you sure you want to clear the transactions cache? This will gather the latest transactions from Mollie via the API again. This is not a harmful action.')
                ->requiresConfirmation(),
            ...parent::getActions()
        ];
    }
}
