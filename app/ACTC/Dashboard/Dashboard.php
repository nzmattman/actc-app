<?php

declare(strict_types=1);

namespace ACTC\Dashboard;

use ACTC\Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dashboard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dashboard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dashboard onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dashboard query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dashboard uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dashboard withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dashboard withoutTrashed()
 * @mixin \Eloquent
 */
class Dashboard extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
    ];
}
