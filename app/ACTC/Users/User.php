<?php

declare(strict_types=1);

namespace ACTC\Users;

use ACTC\Core\Address;
use ACTC\Core\States\Status\StatusState;
use ACTC\Core\Traits\HasAddress;
use ACTC\Core\Traits\HasUuid;
use ACTC\Users\Observers\UserObserver;
use ACTC\Users\States\OnboardingStatus\OnboardingStatusState;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Billable;
use Spatie\ModelStates\HasStates;
use Spatie\ModelStates\HasStatesContract;

/**
 * @property int                                                       $id
 * @property string                                                    $uuid
 * @property null|Carbon                                               $created_at
 * @property null|Carbon                                               $updated_at
 * @property null|Carbon                                               $deleted_at
 * @property null|Carbon                                               $email_verified_at
 * @property int                                                       $address_id
 * @property null|mixed                                                $status
 * @property null|mixed                                                $onboarding_status
 * @property int                                                       $active
 * @property string                                                    $first_name
 * @property string                                                    $last_name
 * @property string                                                    $email
 * @property string                                                    $password
 * @property null|string                                               $remember_token
 * @property Address                                                   $address
 * @property DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property null|int                                                  $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOnboardingStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTrialEndsAt($value)
 * @mixin \Eloquent
 */
#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements HasStatesContract, MustVerifyEmail
{
    use Billable;
    use HasAddress;
    use HasStates;
    use HasUuid;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'status',
        'onboarding_status',
        'email_verified_at',
        'active',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'name',
    ];

    public function stripeName(): ?string
    {
        return $this->name;
    }

    public function stripeAddress(): array
    {
        return [
            'city' => $this->address?->city,
            'country' => 'AU',
            'line1' => $this->address?->street_address,
            'line2' => $this->address?->street_address_2,
            'postal_code' => $this->address?->postcode,
            'state' => $this->address?->state->name,
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => StatusState::class,
            'onboarding_status' => OnboardingStatusState::class,
        ];
    }

    protected function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
