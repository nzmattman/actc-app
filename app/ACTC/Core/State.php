<?php

declare(strict_types=1);

namespace ACTC\Core;

use ACTC\Clubs\Club;
use ACTC\Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State ordered(string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereUuid($value)
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
            ->saveSlugsTo('slug')
        ;
    }

    public function clubs()
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
}
