<?php

declare(strict_types=1);

use ACTC\Notifications\Actions\Destroy;
use ACTC\Notifications\Actions\Index;
use ACTC\Notifications\Actions\ToggleRead;
use Illuminate\Support\Facades\Route;

Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', Index::class)->name('index');
    Route::delete('/{notification}', Destroy::class)->name('delete');
    Route::patch('/{notification}', ToggleRead::class)->name('toggle-read');
});
