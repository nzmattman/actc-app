<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Profile;

use Inertia\Inertia;
use Inertia\Response;

class ProfileEdit
{
    public function __invoke(): Response
    {
        return Inertia::render('Profile/Edit', [
            'status' => session('status'),
        ]);
    }
}
