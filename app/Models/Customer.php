<?php

namespace App\Models;

use App\Traits\HasMollie;
use Illuminate\Support\Facades\Cache;
use Sushi\Sushi;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Sushi,
        HasMollie;

    public function getRows()
    {
        return Cache::remember('mollie-customers', now()->addMinutes(10), function () {
            return collect(
                $this->getMollie()->customers->page(null, 200)->getArrayCopy()
            )
                ->map(function (\Mollie\Api\Resources\Customer $customer) {
                    return [
                        'customer_id' => $customer->id,
                        'name' => $customer->name,
                        'email' => $customer->email,
                        'locale' => $customer->locale,
                        'created_at' => $customer->createdAt
                    ];
                })->toArray();
        });
    }
}
