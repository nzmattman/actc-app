<?php

declare(strict_types=1);

namespace ACTC\Users\States\OnboardingStatus;

class AddressDetails extends OnboardingStatusState
{
    public static $name = 'address_details';

    public function status(): string
    {
        return 'address_details';
    }
}
