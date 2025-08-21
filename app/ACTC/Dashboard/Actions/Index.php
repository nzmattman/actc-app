<?php

declare(strict_types=1);

namespace ACTC\Dashboard\Actions;

use App\ACTC\Dashboard\Resources\ModuleResource;
use App\ACTC\Dashboard\Resources\ResultResource;
use App\ACTC\Dashboard\Resources\RoutineResource;
use Inertia\Inertia;
use Inertia\Response;

class Index
{
    public function __invoke(): Response
    {
        $modules = collect([
            (object) ['uuid' => '1', 'name' => 'Stretch', 'title' => 'Routines', 'icon' => 'stretch', 'route' => 'dashboard'],
            (object) ['uuid' => '2', 'name' => 'Masterclass', 'title' => 'Courses', 'icon' => 'rocket', 'route' => 'dashboard'],
            (object) ['uuid' => '3', 'name' => 'Connect', 'title' => 'Results', 'icon' => 'weight', 'route' => 'dashboard'],
        ]);

        $routines = collect([
            (object) ['uuid' => '4', 'name' => 'The perfect arabesque', 'length' => '10 minutes', 'level' => 'Advanced', 'route' => 'dashboard', 'isFavourite' => true, 'image' => 'arabesque.jpg'],
            (object) ['uuid' => '5', 'name' => 'Leaping straddle', 'length' => '10 minutes', 'level' => 'Medium', 'route' => 'dashboard', 'isFavourite' => false, 'image' => 'leaping.jpg'],
        ]);

        $results = collect([
            (object) ['uuid' => '6', 'name' => 'Cali Champ', 'state' => 'VIC', 'route' => 'dashboard', 'division' => 'Seniors'],
            (object) ['uuid' => '7', 'name' => 'CASA Solo', 'state' => 'SA', 'route' => 'dashboard', 'division' => 'Junior Div 1'],
            (object) ['uuid' => '8', 'name' => 'CAQ Team', 'state' => 'QLD', 'route' => 'dashboard', 'division' => 'Masters'],
            (object) ['uuid' => '9', 'name' => 'Cali Champ 2', 'state' => 'WA', 'route' => 'dashboard', 'division' => 'Junior Division 2'],
        ]);

        return Inertia::render('Dashboard', [
            'modules' => ModuleResource::collection($modules)->resolve(),
            'routines' => RoutineResource::collection($routines)->resolve(),
            'results' => ResultResource::collection($results)->resolve(),
        ]);
    }
}
