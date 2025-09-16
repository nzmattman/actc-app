<?php

declare(strict_types=1);

namespace ACTC\Results;

use ACTC\Core\State;
use ACTC\Core\Traits\HasActive;
use ACTC\Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property int $active
 * @property int $position
 * @property string $name
 * @property int $state_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \ACTC\Results\Result> $results
 * @property-read int|null $results_count
 * @property-read State $state
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory ordered(string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResultCategory withoutTrashed()
 * @mixin \Eloquent
 */
class ResultCategory extends Model
{
    use HasActive;
    use HasUuid;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'uuid',
        'active',
        'position',
        'start_at',
        'end_at',
        'name',
        'state_id',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
