<?php

declare(strict_types=1);

namespace ACTC\Results\Resources;

use ACTC\Results\Actions\GetDateRange;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CompetitionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'dates' => (new GetDateRange())($this->resource),
            'sections' => $this->formatData(),
        ];
    }

    private function formatData(): array
    {
        $data = [];
        foreach ($this->results as $result) {
            $section = $result->section ?? 'Not set';
            if (!isset($data[$section])) {
                $data[$section] = [
                    'name' => $section,
                    'slug' => Str::slug($section),
                    'divisions' => [],
                ];
            }

            $division = trim($result->division) ?: 'Not set';
            if (!isset($data[$section]['divisions'][$division])) {
                $data[$section]['divisions'][$division] = [
                    'name' => $division,
                    'slug' => Str::slug($division),
                ];
            }
        }

        foreach ($data as $section => $sectionData) {
            $data[$section]['divisions'] = array_values($sectionData['divisions']);
        }

        return array_values($data);
    }
}
