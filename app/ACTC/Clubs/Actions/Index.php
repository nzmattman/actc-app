<?php

declare(strict_types=1);

namespace ACTC\Clubs\Actions;

use ACTC\Clubs\Resources\ClubStateResource;
use ACTC\Core\State;
use Inertia\Inertia;
use Inertia\Response;

class Index
{
    public function __invoke(): Response
    {
        $data = State::whereHas('clubs')->with('clubs')->get();

        return Inertia::render('Clubs/Index', [
            'states' => ClubStateResource::collection($data)->resolve(),
        ]);
    }
}
