<?php

declare(strict_types=1);

namespace ACTC\Users\Observers;

use ACTC\Users\User;

class UserObserver
{
    public function updated(User $user): void
    {
        if ($user->hasStripeId()) {
            $user->syncStripeCustomerDetails();
        }
    }
}
