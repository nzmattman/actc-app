<?php

declare(strict_types=1);

namespace ACTC\Admin;

use ACTC\Admin\Observers\AdminObserver;
use ACTC\Core\Traits\HasUuid;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([AdminObserver::class])]
class Admin extends Authenticatable implements FilamentUser, HasName, MustVerifyEmail
{
    use CanResetPassword;
    use HasUuid;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'active',
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

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
