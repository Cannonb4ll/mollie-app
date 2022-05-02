<?php

namespace App\Traits;

use Mollie\Api\MollieApiClient;

trait HasMollie
{
    public function getMollie(): MollieApiClient
    {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(config('services.mollie.token'));

        return $mollie;
    }
}
