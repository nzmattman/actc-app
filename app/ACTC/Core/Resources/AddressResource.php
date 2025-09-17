<?php

declare(strict_types=1);

namespace ACTC\Core\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'state_id' => $this->state_id,
            'street_address' => $this->street_address,
            'street_address_2' => $this->street_address_2,
            'suburb' => $this->suburb,
            'city' => $this->city,
            'postcode' => $this->postcode,
        ];
    }
}
