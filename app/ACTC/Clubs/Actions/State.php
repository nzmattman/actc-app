<?php

declare(strict_types=1);

namespace ACTC\Clubs\Actions;

use ACTC\Clubs\Resources\ClubsResource;
use Inertia\Inertia;
use Inertia\Response;

class State
{
    public function __invoke(string $slug): Response
    {
        $state = \ACTC\Core\State::whereSlug($slug)->with('clubs')->firstOrFail();

        $config = [
            'clubs' => ClubsResource::collection($state->clubs)->resolve(),
            'state' => $state->name,
            'slug' => $state->slug,
            'name' => $state->name.' Clubs',
        ];

        $view = 'Clubs/State';
        if ('clubs.map' === request()->route()->getName()) {
            $view = 'Clubs/StateMap';

            $config['clubs'] = array_values(array_filter($config['clubs'], function ($value) {
                if (isset($value['latitude'], $value['longitude']) && $value['latitude'] && $value['longitude']) {
                    return true;
                }

                return false;
            }));
        }

        return Inertia::render($view, $config);
    }
}
