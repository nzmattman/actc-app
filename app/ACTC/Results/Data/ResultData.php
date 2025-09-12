<?php

declare(strict_types=1);

namespace ACTC\Results\Data;

use Spatie\LaravelData\Data;

class ResultData extends Data
{
    public function __construct(
        public ?string $field,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self();
    }
}
