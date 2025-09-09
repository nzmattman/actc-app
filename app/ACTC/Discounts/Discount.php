<?php

declare(strict_types=1);

namespace ACTC\Discounts;

use ACTC\Core\Traits\HasActive;
use ACTC\Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasActive;
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'expires_at',
        'active',
        'name',
        'code',
        'type',
        'weeks',
        'value',
        'percent',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }
}
