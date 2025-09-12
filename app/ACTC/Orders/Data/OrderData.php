<?php

declare(strict_types=1);

namespace ACTC\Orders\Data;

use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public ?string $field,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self();
    }
}
