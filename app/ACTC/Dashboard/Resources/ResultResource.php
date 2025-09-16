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
        \Log::info(print_r($this->resource::class, true));
        \Log::info((new GetDateRange())($this->resource));

        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'state' => $this->state->code,
            'slug' => $this->state->slug,
            'date' => (new GetDateRange())($this->resource),
        ];
    }
}
