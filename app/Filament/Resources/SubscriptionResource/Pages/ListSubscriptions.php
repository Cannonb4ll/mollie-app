<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use App\Filament\Resources\SubscriptionResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getActions(): array
    {
        return [
            ButtonAction::make('refresh')->color('secondary')
                ->action(function() {
                    cache()->forget('mollie-subscriptions');

                    $this->notify('success', 'Cache for subscriptions have been cleared, you\'re seeing latest data.');
                })
                ->modalSubheading('Are you sure you want to clear the subscriptions cache? This will gather the latest subscriptions from Mollie via the API again. This is not a harmful action.')
                ->requiresConfirmation(),
            ...parent::getActions()
        ];
    }
}
