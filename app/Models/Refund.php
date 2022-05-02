<?php

namespace App\Models;

use App\Traits\HasMollie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Sushi\Sushi;

class Refund extends Model
{
    use Sushi,
        HasMollie;

    public function getRows()
    {
        return Cache::remember('mollie-refunds', now()->addMinutes(10), function () {
            return collect(
                $this->getMollie()->refunds->page(null, 200)->getArrayCopy()
            )
                ->map(function (\Mollie\Api\Resources\Refund $refund) {
                    ray($refund);
                    return [
                        'refund_id' => $refund->id,
                        'description' => $refund->description,
                        'payment_id' => $refund->paymentId,
                        'status' => $refund->status,
                        'total' => $refund->settlementAmount->value * 100,
                        'currency' => $refund->settlementAmount->currency,
                        'created_at' => $refund->createdAt
                    ];
                })->toArray();
        });
    }
}
