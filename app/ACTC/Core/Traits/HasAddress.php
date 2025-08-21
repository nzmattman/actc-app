<?php

declare(strict_types=1);

namespace ACTC\Core\Traits;

use ACTC\Core\Address;

trait HasAddress
{
    public function fillAddress(array $data): array
    {
        if (isset($data['address_id'])) {
            $address = Address::find($data['address_id']);
            if ($address) {
                $data['address'] = [
                    'street_address' => $address->street_address,
                    'street_address_2' => $address->street_address_2,
                    'suburb' => $address->suburb,
                    'city' => $address->city,
                    'state_id' => $address->state_id,
                    'postcode' => $address->postcode,
                ];
            }
        }

        return $data;
    }

    public function fillAddressUpdate(array $data): array
    {
        if (isset($this->record->address)) {
            $this->record->address->update([
                'street_address' => $data['address']['street_address'],
                'street_address_2' => $data['address']['street_address_2'],
                'suburb' => $data['address']['suburb'],
                'city' => $data['address']['city'],
                'state_id' => $data['address']['state_id'],
                'postcode' => $data['address']['postcode'],
            ]);
        }

        // Remove the nested address data
        unset($data['address']);

        return $data;
    }

    public function fillAddressCreate(array $data): array
    {
        // Create the address first
        $address = Address::create([
            'street_address' => $data['address']['street_address'],
            'street_address_2' => $data['address']['street_address_2'],
            'suburb' => $data['address']['suburb'],
            'city' => $data['address']['city'],
            'state_id' => $data['address']['state_id'],
            'country' => 'AUS',
            'postcode' => $data['address']['postcode'],
        ]);

        // Set the address_id for the main record
        $data['address_id'] = $address->id;

        // Remove the nested address data since we've already created the address
        unset($data['address']);

        return $data;
    }
}
