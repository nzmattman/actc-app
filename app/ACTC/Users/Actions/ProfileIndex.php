<?php

declare(strict_types=1);

namespace ACTC\Users\Actions;

use Inertia\Inertia;
use Inertia\Response;

class ProfileIndex
{
    public function __invoke(): Response
    {
        return Inertia::render('Profile/Index');
    }
}
