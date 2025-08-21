<?php

declare(strict_types=1);

namespace ACTC\Dashboard\Data;

use Spatie\LaravelData\Data;

class DashboardData extends Data
{
    public function __construct(
        public ?string $field,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self();
    }
}
