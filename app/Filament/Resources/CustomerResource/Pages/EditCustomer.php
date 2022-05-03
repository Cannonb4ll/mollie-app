<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Traits\HasMollie;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditCustomer extends EditRecord
{
    use HasMollie;

    protected static string $resource = CustomerResource::class;

    public function getTitle(): string
    {
        return 'Edit ' . $this->record->customer_id;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $this->getMollie()->customers->update($record->customer_id, [
            'name' => Arr::get($data, 'name'),
            'email' => Arr::get($data, 'email'),
            'locale' => Arr::get($data, 'locale'),
            'metadata' => Arr::get($data, 'metadata'),
        ]);

        cache()->forget('mollie-customers');

        return $record;
    }

    public function beforeDelete()
    {
        $this->getMollie()->customers->delete($this->record->customer_id);

        cache()->forget('mollie-customers');
    }
}
