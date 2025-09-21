<?php

declare(strict_types=1);

use ACTC\Users\Actions\Address\AddressEdit;
use ACTC\Users\Actions\Address\AddressUpdate;
use ACTC\Users\Actions\Card\CardCreate;
use ACTC\Users\Actions\Card\CardDefault;
use ACTC\Users\Actions\Card\CardDelete;
use ACTC\Users\Actions\Card\CardIndex;
use ACTC\Users\Actions\Card\CardStore;
use ACTC\Users\Actions\Password\PasswordEdit;
use ACTC\Users\Actions\Password\PasswordUpdate;
use ACTC\Users\Actions\Profile\ProfileEdit;
use ACTC\Users\Actions\Profile\ProfileIndex;
use ACTC\Users\Actions\Profile\ProfileUpdate;
use Illuminate\Support\Facades\Route;

Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', ProfileIndex::class)->name('index');
    Route::get('/edit', ProfileEdit::class)->name('edit');
    Route::patch('/', ProfileUpdate::class)->name('update');

    Route::get('/address/edit', AddressEdit::class)->name('address.edit');
    Route::patch('/address', AddressUpdate::class)->name('address.update');

    Route::get('/update-password', PasswordEdit::class)->name('password.edit');
    Route::put('/reset-password', PasswordUpdate::class)->name('password.update');

    Route::get('/cards', CardIndex::class)->name('card');
    Route::get('/cards/create', CardCreate::class)->name('card.create');
    Route::patch('/cards/store', CardStore::class)->name('card.store');
    Route::delete('/cards/{id}', CardDelete::class)->name('card.delete');
    Route::patch('/cards/{id}', CardDefault::class)->name('card.default');
});
