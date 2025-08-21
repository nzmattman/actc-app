<?php

declare(strict_types=1);

namespace App\ACTC\Dashboard\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'state' => $this->state,
            'division' => $this->division,
            'route' => $this->route,
        ];
    }
}
