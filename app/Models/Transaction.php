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
            return collect($this->getMollie()->payments->page(null, 200)->getArrayCopy())
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
        });
    }
}
