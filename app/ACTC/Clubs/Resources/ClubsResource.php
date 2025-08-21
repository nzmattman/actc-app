<?php

declare(strict_types=1);

namespace ACTC\Clubs\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClubsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
            'address' => $this->address->street_address,
            'address2' => $this->address->street_address_2,
            'suburb' => $this->address->suburb,
            'city' => $this->address->city,
            'state' => $this->address->state->name,
            'postcode' => $this->address->postcode,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
        ];
    }
}
