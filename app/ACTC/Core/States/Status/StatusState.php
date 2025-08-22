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
            ->ignoreSameState()
            ->default(Draft::class)
        ;
    }
}
