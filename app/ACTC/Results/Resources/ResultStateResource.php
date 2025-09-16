<?php

declare(strict_types=1);

namespace ACTC\Results\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultStateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'last_updated' => $this->updated_at->format('jS F Y'),
            'route' => 'results.state',
            'slug' => $this->slug,
            'state' => strtolower($this->code),
        ];
    }
}
