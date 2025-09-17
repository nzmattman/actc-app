<?php

declare(strict_types=1);

namespace ACTC\Core\Data;

use Spatie\LaravelData\Data;

class AddressData extends Data
{
    public function __construct(
        public string $street_address,
        public ?string $street_address_2,
        public ?string $suburb,
        public ?string $city,
        public int $state_id,
        public ?string $postcode = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['street_address'],
            $data['street_address_2'],
            $data['suburb'],
            $data['city'],
            $data['state_id'],
            $data['postcode'],
        );
    }
}
