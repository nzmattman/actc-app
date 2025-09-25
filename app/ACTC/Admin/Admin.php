<?php

declare(strict_types=1);

namespace ACTC\Admin;

use ACTC\Admin\Observers\AdminObserver;
use ACTC\Core\States\Status\Active;
use ACTC\Core\States\Status\StatusState;
use ACTC\Core\Traits\HasUuid;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

#[ObservedBy([AdminObserver::class])]
/**
 * @property int                                                       $id
 * @property string                                                    $uuid
 * @property null|Carbon                                               $created_at
 * @property null|Carbon                                               $updated_at
 * @property null|Carbon                                               $email_verified_at
 * @property null|Carbon                                               $deleted_at
 * @property int                                                       $active
 * @property string                                                    $first_name
 * @property string                                                    $last_name
 * @property string                                                    $email
 * @property string                                                    $password
 * @property null|string                                               $remember_token
 * @property string                                                    $name
 * @property DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property null|int                                                  $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin withoutTrashed()
 * @property null|string $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereStatus($value)
 * @mixin \Eloquent
 */
class Admin extends Authenticatable implements FilamentUser, HasName, MustVerifyEmail
{
    use CanResetPassword;
    use HasUuid;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'status',
        'first_name',
        'last_name',
        'email',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'name',
    ];

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getAuthPassword()
    {
        if (!is_a($this->status, Active::class)) {
            return null;
        }

        return $this->password;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => StatusState::class,
        ];
    }

    protected function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
