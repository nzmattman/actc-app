<?php

declare(strict_types=1);

namespace ACTC\Users\Listeners;

use ACTC\Core\States\Status\Cancelled;
use ACTC\Users\User;
use Laravel\Cashier\Events\WebhookReceived;

class StripeSubscriptionCancelled
{
    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ('customer.subscription.deleted' === $event->payload['type']) {
            $user = User::where('stripe_id', $event->payload['data']['object']['customer'])->first();
            $user?->status->transitionTo(Cancelled::class);
        }
    }
}
