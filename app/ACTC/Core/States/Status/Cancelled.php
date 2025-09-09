<?php

declare(strict_types=1);

namespace ACTC\Core\States\Status;

class Cancelled extends StatusState
{
    public static $name = 'cancelled';

    public function status(): string
    {
        return 'cancelled';
    }
}
