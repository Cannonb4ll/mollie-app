<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use App\Traits\HasMollie;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Cache;

class ListTransactions extends ListRecords
{
    use HasMollie;

    protected static string $resource = TransactionResource::class;

    protected function getActions(): array
    {
        return [
            ButtonAction::make('load_more')->color('secondary')
                ->action(function () {
                    $oldest = Transaction::query()->oldest()->first();

                    $current = Cache::get('mollie-transactions');
                    $new = collect($this->getMollie()->payments->page($oldest->payment_id, 200)->getArrayCopy())
                        ->map(function (\Mollie\Api\Resources\Payment $payment) {
                            return [
                                'payment_id' => $payment->id,
                                'customer_id' => $payment->customerId,
                                'subscription_id' => $payment->subscriptionId,
                                'status' => $payment->status,
                                'total' => $payment->amount->value * 100,
                                'currency' => $payment->amount->currency,
                                'description' => $payment->description,
                                'created_at' => $payment->createdAt
                            ];
                        })->toArray();

                    $result = array_merge($current, $new);

                    Cache::put('mollie-transactions', $result, now()->addMinutes(10));

                    $this->notify('success', 'More are loaded, there are now ' . count($result) . ' transactions available.');

                    return redirect()->route('filament.resources.transactions.index');
                })
                ->modalSubheading('This will load more transactions from the Mollie API. If there are not more transactions available, it will not increase.')
                ->requiresConfirmation(),

            ButtonAction::make('refresh')->color('secondary')
                ->action(function () {
                    cache()->forget('mollie-transactions');

                    $this->notify('success', 'Cache for transactions have been cleared, you\'re seeing latest data.');
                })
                ->modalSubheading('Are you sure you want to clear the transactions cache? This will gather the latest transactions from Mollie via the API again. This is not a harmful action.')
                ->requiresConfirmation(),
            ...parent::getActions()
        ];
    }
}
