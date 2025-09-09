<?php

declare(strict_types=1);

namespace ACTC\Discounts\Data;

use Spatie\LaravelData\Data;

class DiscountData extends Data
{
    public function __construct(
        public ?string $field,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self();
    }
}
