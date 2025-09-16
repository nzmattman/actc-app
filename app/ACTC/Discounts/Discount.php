<?php

declare(strict_types=1);

namespace ACTC\Discounts;

use ACTC\Core\Traits\HasActive;
use ACTC\Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property int $active
 * @property string|null $name
 * @property string $code
 * @property int $type
 * @property int|null $weeks
 * @property int|null $value
 * @property int|null $percent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereWeeks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount withoutTrashed()
 * @mixin \Eloquent
 */
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
