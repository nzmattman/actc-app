<?php

declare(strict_types=1);

namespace ACTC\Users\States\OnboardingStatus;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class OnboardingStatusState extends State
{
    abstract public function status(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->allowTransition(UserDetails::class, AddressDetails::class)
            ->allowTransition(AddressDetails::class, PaymentDetails::class)
            ->allowTransition(PaymentDetails::class, Completed::class)
            ->ignoreSameState()
            ->default(UserDetails::class)
        ;
    }
}
