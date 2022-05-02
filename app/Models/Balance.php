<?php

namespace App\Models;

use App\Traits\HasMollie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Sushi\Sushi;

class Balance extends Model
{
    use Sushi,
        HasMollie;

    public function getRows()
    {
        return Cache::remember('mollie-balances', now()->addMinutes(10), function () {
            return collect(
                $this->setoAuthToken(config('services.mollie.oauth'))
                    ->setVia('oauth')
                    ->getMollie()
                    ->performHttpCallToFullUrl(
                        'get',
                        'https://api.mollie.com/v2/balances'
                    )
                    ->_embedded->balances
            )
                ->map(function($balance){
                    return [
                        'balance_id' => $balance->id,
                        'currency' => $balance->availableAmount->currency,
                        'available' => $balance->availableAmount->value * 100,
                        'incoming' => $balance->incomingAmount->value * 100,
                        'created_at' => $balance->createdAt
                    ];
                })
                ->toArray();
        });
    }
}
