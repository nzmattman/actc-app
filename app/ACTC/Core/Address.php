<?php

declare(strict_types=1);

namespace ACTC\Core;

use ACTC\Core\Traits\HasUuid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
