<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Card;

use Inertia\Inertia;
use Inertia\Response;

class CardCreate
{
    public function __invoke(): Response
    {
        $config = [
            'intent' => auth()->user()->createSetupIntent()->client_secret,
        ];

        return Inertia::render('Profile/Card/Create', $config);
    }
}
