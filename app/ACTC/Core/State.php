<?php

declare(strict_types=1);

namespace ACTC\Core;

use ACTC\Clubs\Club;
use ACTC\Core\Traits\HasUuid;
use ACTC\Results\ResultCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $position
 * @property string $name
 * @property string $code
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Club> $clubs
 * @property-read int|null $clubs_count
 * @method static Builder<static>|State newModelQuery()
 * @method static Builder<static>|State newQuery()
 * @method static Builder<static>|State ordered(string $direction = 'asc')
 * @method static Builder<static>|State query()
 * @method static Builder<static>|State uuid(string $uuid)
 * @method static Builder<static>|State whereCode($value)
 * @method static Builder<static>|State whereCreatedAt($value)
 * @method static Builder<static>|State whereId($value)
 * @method static Builder<static>|State whereName($value)
 * @method static Builder<static>|State wherePosition($value)
 * @method static Builder<static>|State whereSlug($value)
 * @method static Builder<static>|State whereUpdatedAt($value)
 * @method static Builder<static>|State whereUuid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ResultCategory> $competitions
 * @property-read int|null $competitions_count
 * @mixin \Eloquent
 */
class State extends Model implements Sortable
{
    use HasSlug;
    use HasUuid;
    use SortableTrait;

    protected $fillable = [
        'uuid',
        'position',
        'name',
        'code',
        'slug',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function clubs(): HasManyThrough
    {
        return $this->hasManyThrough(
            Club::class,     // Final model we want
            Address::class,  // Intermediate model
            'state_id',      // Foreign key on addresses table
            'address_id',    // Foreign key on clubs table
            'id',            // Local key on states table
            'id'             // Local key on addresses table
        );
    }

    public function competitions()
    {
        return $this->hasMany(ResultCategory::class);
    }
}
