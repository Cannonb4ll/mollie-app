<?php

namespace App\Traits;

use Mollie\Api\MollieApiClient;

trait HasMollie
{
    public string $via = 'key';
    public string $oAuthToken = '';

    public function getMollie(): MollieApiClient
    {
        $mollie = new \Mollie\Api\MollieApiClient();

        if($this->via === 'key'){
            $mollie->setApiKey(config('services.mollie.token'));
        }

        if($this->via === 'oauth'){
            $mollie->setAccessToken($this->oAuthToken);
        }

        return $mollie;
    }

    public function setoAuthToken($token)
    {
        $this->oAuthToken = $token;

        return $this;
    }

    public function setVia($via)
    {
        $this->via = $via;

        return $this;
    }
}
