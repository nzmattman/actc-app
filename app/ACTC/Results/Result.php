<?php

declare(strict_types=1);

namespace ACTC\Results;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int                 $id
 * @property null|Carbon         $created_at
 * @property null|Carbon         $updated_at
 * @property null|Carbon         $deleted_at
 * @property int                 $result_category_id
 * @property null|string         $section
 * @property null|string         $division
 * @property null|string         $item
 * @property null|string         $position
 * @property null|string         $name
 * @property null|int            $points
 * @property null|ResultCategory $category
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereResultCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Result extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'result_category_id',
        'section',
        'section_slug',
        'division',
        'division_slug',
        'item',
        'position',
        'name',
        'points',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ResultCategory::class);
    }
}
