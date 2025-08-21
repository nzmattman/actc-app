<?php

declare(strict_types=1);

namespace ACTC\Core\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasActive
{
    protected function scopeActive(Builder $query)
    {
        return $query->whereActive(true);
    }
}
