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
