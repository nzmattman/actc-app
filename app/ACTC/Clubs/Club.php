<?php

declare(strict_types=1);

namespace ACTC\Clubs;

use ACTC\Clubs\Observers\ClubObserver;
use ACTC\Core\Address;
use ACTC\Core\Traits\HasActive;
use ACTC\Core\Traits\HasAddress;
use ACTC\Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\SortableTrait;

#[ObservedBy([ClubObserver::class])]
/**
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $active
 * @property int $position
 * @property int $address_id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $website
 * @property string|null $latitude
 * @property string|null $longitude
 * @property-read Address $address
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club ordered(string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Club withoutTrashed()
 * @mixin \Eloquent
 */
class Club extends Model
{
    use HasActive;
    use HasUuid;
    use SoftDeletes;
    use SortableTrait;
    use HasAddress;

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
}
