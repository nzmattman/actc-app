<?php

declare(strict_types=1);

namespace ACTC\Clubs;

use ACTC\Clubs\Observers\ClubObserver;
use ACTC\Core\Address;
use ACTC\Core\Traits\HasActive;
use ACTC\Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\SortableTrait;

#[ObservedBy([ClubObserver::class])]
class Club extends Model
{
    use HasActive;
    use HasUuid;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'uuid',
        'state_id',
        'address_id',
        'active',
        'name',
        'email',
        'phone',
        'website',
        'latitude',
        'longitude',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
