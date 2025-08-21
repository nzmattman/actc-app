<?php

declare(strict_types=1);

use Inertia\Inertia;

Route::middleware('guest')->get('/', function () {
    return Inertia::render('Welcome');
});

Route::fallback(function () {
    return redirect('dashboard');
});
