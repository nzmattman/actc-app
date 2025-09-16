<?php

declare(strict_types=1);

namespace ACTC\Orders;

use ACTC\Core\Traits\HasUuid;
use ACTC\Core\Traits\HasActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order ordered(string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasUuid;
    use HasActive;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'uuid',
        'active',
        'position',
    ];
}
