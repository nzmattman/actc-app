<?php

declare(strict_types=1);

namespace ACTC\Admin\Observers;

use ACTC\Admin\Admin;
use ACTC\Admin\Notifications\AdminWelcome;
use Illuminate\Support\Str;

class AdminObserver
{
    public function creating(Admin $admin): void
    {
        // create a random password
        $admin->password = Str::random(10);
    }

    public function created(Admin $admin): void
    {
        // queue and send the email
        $admin->notify(new AdminWelcome());
    }
}
