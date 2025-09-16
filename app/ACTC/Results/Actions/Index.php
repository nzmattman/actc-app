<?php

declare(strict_types=1);

namespace ACTC\Results\Actions;

use ACTC\Core\State;
use ACTC\Results\Resources\ResultStateResource;
use Inertia\Inertia;
use Inertia\Response;

class Index
{
    public function __invoke(): Response
    {
        $data = State::whereHas('competitions')->with('competitions')->get();

        return Inertia::render('Results/Index', [
            'states' => ResultStateResource::collection($data)->resolve(),
        ]);
    }
}
