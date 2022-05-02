<?php

namespace App\Models;

use App\Traits\HasMollie;
use Illuminate\Support\Facades\Cache;
use Sushi\Sushi;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Sushi,
        HasMollie;

    public function getRows()
    {
        return Cache::remember('mollie-transactions', now()->addMinutes(10), function () {
            return collect($this->getMollie()->payments->page(null, 50)->getArrayCopy())
                ->map(function (\Mollie\Api\Resources\Payment $payment) {
                    return [
                        'payment_id' => $payment->id,
                        'status' => $payment->status,
                        'description' => $payment->description,
                        'created_at' => $payment->createdAt
                    ];
                })->toArray();
        });
    }
}
