<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use App\Filament\Resources\SubscriptionResource;
use App\Traits\HasMollie;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditSubscription extends EditRecord
{
    use HasMollie;

    protected static string $resource = SubscriptionResource::class;

    public function getTitle(): string
    {
        return 'Edit ' . $this->record->subscription_id;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $this->getMollie()->subscriptions->update($record->customer_id, $record->subscription_id, [
            'description' => Arr::get($data, 'description'),
            'amount' => [
                'value' => number_format(Arr::get($data, 'total', 0), 2),
                'currency' => Arr::get($data, 'currency'),
            ],
        ]);

        cache()->forget('mollie-subscriptions');

        return $record;
    }
}
