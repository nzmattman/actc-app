<?php

declare(strict_types=1);

namespace ACTC\Users\States\OnboardingStatus;

class UserDetails extends OnboardingStatusState
{
    public static $name = 'user_details';

    public function status(): string
    {
        return 'user_details';
    }
}
