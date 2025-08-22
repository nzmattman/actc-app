<?php

declare(strict_types=1);

namespace ACTC\Users\States\OnboardingStatus;

class PaymentDetails extends OnboardingStatusState
{
    public static $name = 'payment_details';

    public function status(): string
    {
        return 'payment_details';
    }
}
