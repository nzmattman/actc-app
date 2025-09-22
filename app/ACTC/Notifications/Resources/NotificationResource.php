<?php

declare(strict_types=1);

namespace ACTC\Notifications\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->created_at->diffForHumans(),
            'created' => $this->created_at,
            'read' => (bool) $this->read_at,
            'heading' => $this->data['heading'] ?? null,
            'message' => $this->data['message'] ?? null,
        ];
    }
}
