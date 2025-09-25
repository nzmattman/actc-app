<?php

declare(strict_types=1);

use ACTC\Users\Actions\Profile\ProfileCancelled;
use ACTC\Users\Actions\Register\Step01;
use ACTC\Users\Actions\Register\Step01Save;
use ACTC\Users\Actions\Register\Step02;
use ACTC\Users\Actions\Register\Step02Save;
use ACTC\Users\Actions\Register\Step03;
use ACTC\Users\Actions\Register\Step03Save;
use Illuminate\Support\Facades\Route;

Route::prefix('register')
    ->middleware(['guest', 'redirectIfAdmin'])
    ->name('register.')
    ->group(function () {
        Route::get('/', Step01::class)->name('step-one');
        Route::post('/', Step01Save::class)->name('step-one.save');
    })
;

Route::prefix('register')
    ->name('register.')
    ->middleware(['auth:web', 'redirectIfAdmin'])
    ->group(function () {
        Route::get('/address-details', Step02::class)->name('step-two');
        Route::post('/address-details', Step02Save::class)->name('step-two.save');
        Route::get('/payment-details', Step03::class)->name('step-three');
        Route::post('/payment-details', Step03Save::class)->name('step-three.save');
    })
;

Route::middleware(['auth:web', 'redirectIfAdmin'])
    ->name('profile.')
    ->prefix('profile')
    ->group(function () {
        Route::get('/cancelled', ProfileCancelled::class)->name('cancelled');
    })
;
