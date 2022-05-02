<?php

namespace App\Models;

use App\Traits\HasMollie;
use Sushi\Sushi;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use Sushi,
        HasMollie;

    public function getRows()
    {
        return collect(
            $this->getMollie()->subscriptions->page(null, 200)->getArrayCopy()
        )
            ->map(function (\Mollie\Api\Resources\Subscription $subscription) {
                return [
                    'subscription_id' => $subscription->id,
                    'status' => $subscription->status,
                    'method' => $subscription->method,
                    'description' => $subscription->description,
                    'interval' => $subscription->interval,
                    'times' => $subscription->times,
                    'times_remaining' => $subscription->timesRemaining,
                    'meta' => json_encode($subscription->metadata),
                    'total' => $subscription->amount->value,
                    'currency' => $subscription->amount->currency,
                    'customer_id' => $subscription->customerId,
                    'mandate_id' => $subscription->mandateId,
                    'created_at' => $subscription->createdAt,
                    'started_at' => $subscription->startDate,
                    'webhook_url' => $subscription->webhookUrl,
                ];
            })->toArray();
    }
}
