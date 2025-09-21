<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Profile;

use Inertia\Inertia;
use Inertia\Response;

class ProfileCancelled
{
    public function __invoke(): Response
    {
        return Inertia::render('Profile/Cancelled');
    }
}
