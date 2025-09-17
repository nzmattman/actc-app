<?php

declare(strict_types=1);

namespace App\ACTC\Dashboard\Resources;

use ACTC\Results\Actions\GetDateRange;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $item = $this->results->first();

        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'state' => $this->state->code,
            'slug' => [
                'state' => $this->state->slug,
                'competition' => $this->uuid,
                'section' => $item->section_slug,
                'division' => $item->division_slug ?? 'not-set',
            ],
            'date' => (new GetDateRange())($this->resource),
        ];
    }
}
