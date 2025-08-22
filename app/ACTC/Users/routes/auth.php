<?php

declare(strict_types=1);

use ACTC\Users\Actions\PasswordEdit;
use ACTC\Users\Actions\PasswordUpdate;
use ACTC\Users\Actions\ProfileEdit;
use ACTC\Users\Actions\ProfileIndex;
use ACTC\Users\Actions\ProfileUpdate;
use Illuminate\Support\Facades\Route;

Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', ProfileIndex::class)->name('index');
    Route::get('/edit', ProfileEdit::class)->name('edit');
    Route::patch('/', ProfileUpdate::class)->name('update');

    Route::get('/update-password', PasswordEdit::class)->name('password.edit');
    Route::put('/reset-password', PasswordUpdate::class)->name('password.update');
});
