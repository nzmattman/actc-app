<?php

declare(strict_types=1);

namespace ACTC\Results\Resources;

use ACTC\Results\Actions\GetDateRange;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CompetitionSimpleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'dates' => (new GetDateRange())($this->resource),
        ];
    }
}
