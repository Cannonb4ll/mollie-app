<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use App\Filament\Resources\SubscriptionResource;
use App\Traits\HasMollie;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditSubscription extends EditRecord
{
    use HasMollie;

    protected static string $resource = SubscriptionResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $mappedData = [
            'description' => \Arr::get($data, 'description')
        ];

        $this->getMollie()->subscriptions->update($record->customer_id, $record->subscription_id, $mappedData);

        return $record;
    }
}
