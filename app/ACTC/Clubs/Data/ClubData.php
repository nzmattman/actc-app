<?php

declare(strict_types=1);

namespace ACTC\Clubs\Data;

use Spatie\LaravelData\Data;

class ClubData extends Data
{
    public function __construct(
        public ?string $field,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self();
    }
}
