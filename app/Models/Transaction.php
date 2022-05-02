<?php

namespace App\Models;

use Sushi\Sushi;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Sushi;

    public function getRows()
    {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey("test_h9nwbkHbDbzjJHVQNFWSQCByGpqntj");

        return collect($mollie->payments->page(null, 50)->getArrayCopy())->map(function (\Mollie\Api\Resources\Payment $payment) {
            return [
                'payment_id' => $payment->id,
                'status' => $payment->status,
                'description' => $payment->description,
            ];
        })->toArray();
    }
}
