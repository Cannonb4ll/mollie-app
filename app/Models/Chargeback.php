<?php

namespace App\Models;

use App\Traits\HasMollie;
use Sushi\Sushi;
use Illuminate\Database\Eloquent\Model;

class Chargeback extends Model
{
    use Sushi,
        HasMollie;

    public function getRows()
    {
        return collect(
            $this->getMollie()->chargebacks->page(null, 200)->getArrayCopy()
        )
            ->map(function (\Mollie\Api\Resources\Chargeback $chargeback) {
//                return [
//                    'customer_id' => $customer->id,
//                    'name' => $customer->name,
//                    'email' => $customer->email,
//                    'locale' => $customer->locale,
//                ];
            })->toArray();
    }
}
