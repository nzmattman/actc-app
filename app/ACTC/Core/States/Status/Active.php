<?php

declare(strict_types=1);

namespace ACTC\Core\States\Status;

class Active extends StatusState
{
    public static $name = 'active';

    public function status(): string
    {
        return 'active';
    }
}
