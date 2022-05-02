<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Traits\HasMollie;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTransaction extends EditRecord
{
    use HasMollie;

    protected static string $resource = TransactionResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $mappedData = [
            'description' => \Arr::get($data, 'description')
        ];

        $this->getMollie()->payments->update($record->payment_id, $mappedData);

        cache()->forget('mollie-transactions');

        return $record;
    }
}
