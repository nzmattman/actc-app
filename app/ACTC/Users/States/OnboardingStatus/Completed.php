<?php

declare(strict_types=1);

namespace ACTC\Users\States\OnboardingStatus;

class Completed extends OnboardingStatusState
{
    public static $name = 'completed';

    public function status(): string
    {
        return 'completed';
    }
}
