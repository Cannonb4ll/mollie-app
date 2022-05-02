<?php

namespace App\Filament\Resources\RefundResource\Pages;

use App\Filament\Resources\RefundResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;

class ListRefunds extends ListRecords
{
    protected static string $resource = RefundResource::class;

    protected function getActions(): array
    {
        return [
            ButtonAction::make('refresh')->color('secondary')
                ->action(function() {
                    cache()->forget('mollie-refunds');

                    $this->notify('success', 'Cache for refunds have been cleared, you\'re seeing latest data.');
                })
                ->modalSubheading('Are you sure you want to clear the refunds cache? This will gather the latest refunds from Mollie via the API again. This is not a harmful action.')
                ->requiresConfirmation(),
            ...parent::getActions()
        ];
    }
}
