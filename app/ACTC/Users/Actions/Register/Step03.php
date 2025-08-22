<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Register;

use Inertia\Inertia;
use Inertia\Response;

class Step03
{
    public function __invoke(): Response
    {
        return Inertia::render('Auth/Register/Step03');
    }
}
