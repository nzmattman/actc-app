<?php

declare(strict_types=1);

namespace ACTC\Clubs\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClubStateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name.' Clubs',
            'count' => $this->clubs->count(),
            'route' => 'clubs.state',
            'slug' => $this->slug,
            'state' => strtolower($this->code),
        ];
    }
}
