<?php

declare(strict_types=1);

namespace ACTC\Core\States\Status;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class StatusState extends State
{
    abstract public function status(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->allowTransition(Draft::class, Active::class)
            ->allowTransition(Active::class, Draft::class)
            ->allowTransition(Draft::class, Cancelled::class)
            ->allowTransition(Active::class, Cancelled::class)
            ->allowTransition(Cancelled::class, Active::class)
            ->allowTransition(Cancelled::class, Draft::class)
            ->ignoreSameState()
            ->default(Draft::class)
        ;
    }
}
