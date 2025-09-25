<?php

declare(strict_types=1);

use ACTC\Dashboard\Actions\Index;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', Index::class)->middleware(['auth', 'verified', 'redirectIfAdmin'])->name('dashboard');
