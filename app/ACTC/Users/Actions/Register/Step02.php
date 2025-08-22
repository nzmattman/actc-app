<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Register;

use ACTC\Core\Resources\StateSelectResource;
use ACTC\Core\State;
use Inertia\Inertia;
use Inertia\Response;

class Step02
{
    public function __invoke(): Response
    {
        $config = [
            'states' => StateSelectResource::collection(State::all())->resolve(),
        ];

        return Inertia::render('Auth/Register/Step02', $config);
    }
}
