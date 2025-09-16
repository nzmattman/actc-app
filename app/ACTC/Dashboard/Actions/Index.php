<?php

declare(strict_types=1);

namespace ACTC\Dashboard\Actions;

use ACTC\Results\ResultCategory;
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
            (object) ['uuid' => '3', 'name' => 'Connect', 'title' => 'Results', 'icon' => 'weight', 'route' => 'results'],
        ]);

        $routines = collect([
            (object) ['uuid' => '4', 'name' => 'The perfect arabesque', 'length' => '10 minutes', 'level' => 'Advanced', 'route' => 'dashboard', 'isFavourite' => true, 'image' => 'arabesque.jpg'],
            (object) ['uuid' => '5', 'name' => 'Leaping straddle', 'length' => '10 minutes', 'level' => 'Medium', 'route' => 'dashboard', 'isFavourite' => false, 'image' => 'leaping.jpg'],
        ]);

        $config = [
            'modules' => ModuleResource::collection($modules)->resolve(),
            'routines' => RoutineResource::collection($routines)->resolve(),
            'results' => Inertia::defer(fn () => $this->fetchResults(), 'results'),
        ];

        return Inertia::render('Dashboard', $config);
    }

    private function fetchResults(): array
    {
        $results = ResultCategory::orderBy('start_at', 'desc')->limit(6)->get();

        return ResultResource::collection($results)->resolve();
    }
}
