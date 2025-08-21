<?php

declare(strict_types=1);

namespace App\ACTC\Dashboard\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'icon' => $this->icon,
            'name' => $this->name,
            'title' => $this->title,
            'route' => $this->route,
        ];
    }
}
