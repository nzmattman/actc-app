<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('ACTC.Users.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
