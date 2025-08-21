<?php

declare(strict_types=1);

namespace ACTC\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Use UUID as the route key.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Hook into model events.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * Scope for finding by uuid.
     *
     * @param mixed $uuid
     */
    protected function scopeUuid(Builder $query, string $uuid): self
    {
        return $query->whereUuid($uuid)->first();
    }
}
