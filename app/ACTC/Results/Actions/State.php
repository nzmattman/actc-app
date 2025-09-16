<?php

declare(strict_types=1);

namespace ACTC\Results\Actions;

use ACTC\Results\Resources\CompetitionResource;
use Inertia\Inertia;
use Inertia\Response;

class State
{
    public function __invoke(string $slug): Response
    {
        $state = \ACTC\Core\State::whereSlug($slug)->with('competitions')->firstOrFail();

        $config = [
            'competitions' => CompetitionResource::collection($state->competitions)->resolve(),
            'state' => $state->name,
            'slug' => $state->slug,
            'name' => $state->name,
            'code' => strtolower($state->code),
        ];

        return Inertia::render('Results/State', $config);
    }
}
