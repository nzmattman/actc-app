<?php

declare(strict_types=1);

namespace ACTC\Core\States\Status;

class Draft extends StatusState
{
    public static $name = 'draft';

    public function status(): string
    {
        return 'draft';
    }
}
