<?php

declare(strict_types=1);

namespace ACTC\Results\Actions;

use ACTC\Results\Resources\CompetitionSimpleResource;
use ACTC\Results\ResultCategory;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class Division
{
    public function __invoke(string $slug, ResultCategory $competition, string $section, string $division): Response
    {
        $competition->load('results');

        if ('not-set' === $division) {
            $division = null;
        }

        $results = $competition->results->filter(function ($item) use ($section, $division) {
            if ($item->section_slug === $section && $item->division_slug === $division) {
                return true;
            }

            return false;
        });

        $state = $competition->state;

        $config = [
            'competition' => (new CompetitionSimpleResource($competition))->resolve(),
            'division' => $results->first()->division,
            'state' => $state->name,
            'slug' => $state->slug,
            'aggregate' => $this->find($results, 'Aggregate'),
            'runner_up' => $this->find($results, 'Runner Up'),
            'items' => $this->formatDivisions($results),
        ];

        return Inertia::render('Results/Division', $config);
    }

    private function formatDivisions(Collection $results): array
    {
        return $results
            ->whereNotIn('item', ['Aggregate', 'Runner Up'])
            ->groupBy('item')
            ->map(function ($items, $itemName) {
                return [
                    'name' => $itemName,
                    'places' => $items->sortByDesc('points')->map(function ($item) {
                        return [
                            'name' => $item->name,
                            'position' => $this->formatPosition($item->position),
                            'points' => $item->points,
                        ];
                    })->values()->toArray(),
                ];
            })->values()->toArray()
        ;
    }

    private function find(Collection $results, string $key): ?array
    {
        if ($results->isEmpty()) {
            return null;
        }

        $item = $results->where('item', $key)->first();

        if (!$item) {
            return null;
        }

        return [
            'name' => $item->name,
            'points' => $item->points,
        ];
    }

    private function formatPosition($position): string
    {
        // If it's numeric, convert to ordinal
        if (is_numeric($position)) {
            $number = (int) $position;

            // Handle special cases for 11th, 12th, 13th
            if ($number % 100 >= 11 && $number % 100 <= 13) {
                return $number.'th';
            }

            // Handle regular cases
            return match ($number % 10) {
                1 => $number.'st',
                2 => $number.'nd',
                3 => $number.'rd',
                default => $number.'th',
            };
        }

        // If it's a string, return as-is
        return (string) $position;
    }
}
