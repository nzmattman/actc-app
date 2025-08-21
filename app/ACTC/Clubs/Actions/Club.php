<?php

declare(strict_types=1);

namespace ACTC\Clubs\Actions;

use ACTC\Clubs\Resources\ClubsResource;
use Inertia\Inertia;
use Inertia\Response;

class Club
{
    public function __invoke(string $slug, \ACTC\Clubs\Club $club): Response
    {
        $state = $club->address->state;

        $config = [
            'item' => (new ClubsResource($club))->resolve(),
            'state' => $state->name,
            'slug' => $state->slug,
            'name' => $state->name.' Clubs',
        ];

        return Inertia::render('Clubs/Club', $config);
    }
}
