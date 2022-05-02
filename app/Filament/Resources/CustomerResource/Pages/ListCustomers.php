<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getActions(): array
    {
        return [
            ButtonAction::make('refresh')->color('secondary')
                ->action(function() {
                    cache()->forget('mollie-customers');

                    $this->notify('success', 'Cache for customers have been cleared, you\'re seeing latest data.');
                })
                ->modalSubheading('Are you sure you want to clear the customers cache? This will gather the latest customers from Mollie via the API again. This is not a harmful action.')
                ->requiresConfirmation(),
            ...parent::getActions()
        ];
    }
}
