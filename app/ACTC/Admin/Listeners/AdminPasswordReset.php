<?php

declare(strict_types=1);

namespace ACTC\Admin\Listeners;

use ACTC\Admin\Admin;
use Illuminate\Support\Facades\Auth;

class AdminPasswordReset
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // set the email as verified once the admin has reset the password, but only if it is not yet set
        // it is not set means that the admin has been newly created
        if (is_a($event->user, Admin::class) && ! $event->user->email_verified_at) {
            $event->user->update([
                'email_verified_at' => now(),
            ]);

            // log the user in
            Auth::guard('admin')->login($event->user);
        }
    }
}
