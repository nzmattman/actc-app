<?php

declare(strict_types=1);

namespace ACTC\Core;

use ACTC\Core\Traits\HasUuid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $state_id
 * @property string $street_address
 * @property string|null $street_address_2
 * @property string|null $suburb
 * @property string|null $city
 * @property string|null $state_other
 * @property string|null $country
 * @property string|null $postcode
 * @property-read mixed $full_address
 * @property-read \ACTC\Core\State|null $state
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereStateOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereStreetAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereStreetAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereSuburb($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUuid($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'state_id',
        'street_address',
        'street_address_2',
        'suburb',
        'city',
        'state_other',
        'country',
        'postcode',
    ];

    protected $appends = [
        'full_address',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public static function filamentFields(): Section
    {
        return Section::make('Address')
            ->schema([
                TextInput::make('address.street_address')->label('Street Address')->required()->maxLength(255),
                TextInput::make('address.street_address_2')->label('Street Address 2')->maxLength(255),
                TextInput::make('address.suburb')->label('Suburb')->maxLength(255),
                TextInput::make('address.city')->label('City')->maxLength(255),
                TextInput::make('address.postcode')->label('Postcode'),
                Select::make('address.state_id')
                    ->label('State')
                    ->options(State::pluck('name', 'id'))
                    ->preload()
                    ->searchable()
                    ->required(),
            ])
            ->columns(2)
        ;
    }

    public function getFullAddressAttribute()
    {
        $countries = config('forms.countries');

        $addr = [];
        if ($this->street_address) {
            $addr[] = $this->street_address;
        }
        if ($this->street_address_2) {
            $addr[] = $this->street_address_2;
        }
        if ($this->suburb) {
            $addr[] = $this->suburb;
        }
        if ($this->city) {
            $addr[] = $this->city;
        }
        if ($this->state?->name) {
            $addr[] = $this->state->name;
        }
        if ($this->postcode) {
            $addr[] = $this->postcode;
        }
        if ($this->country) {
            $addr[] = isset($countries[$this->country]) ? $countries[$this->country] : $this->country;
        }

        return implode(', ', $addr);
    }
}
