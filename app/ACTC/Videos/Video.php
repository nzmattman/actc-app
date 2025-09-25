<?php

declare(strict_types=1);

namespace ACTC\Videos;

use ACTC\Core\Traits\HasActive;
use ACTC\Core\Traits\HasUuid;
use ACTC\Users\User;
use ACTC\Videos\Observers\VideoObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Tags\HasTags;

#[ObservedBy([VideoObserver::class])]
/**
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $active
 * @property int $position
 * @property int $featured
 * @property string $name
 * @property string $share_link
 * @property string $thumbnail
 * @property int $view_count
 * @property int|null $duration
 * @property string|null $description
 * @property float|null $price
 * @property \Illuminate\Database\Eloquent\Collection<int, \Spatie\Tags\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video ordered(string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereShareLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video whereViewCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video withAnyTagsOfType(array|string $type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video withoutTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Video withoutTrashed()
 * @mixin \Eloquent
 */
class Video extends Model
{
    use HasActive;
    use HasTags;
    use HasUuid;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'uuid',
        'active',
        'position',
        'featured',
        'name',
        'share_link',
        'thumbnail',
        'view_count',
        'duration',
        'description',
        'price',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
