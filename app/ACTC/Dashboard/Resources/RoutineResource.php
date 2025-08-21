<?php

declare(strict_types=1);

namespace App\ACTC\Dashboard\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoutineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'length' => $this->length,
            'level' => $this->level,
            'route' => $this->route,
            'isFavourite' => $this->isFavourite,
            'image' => asset('storage/routines/'.$this->image),
        ];
    }
}
