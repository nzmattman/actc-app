<?php

declare(strict_types=1);

use ACTC\Clubs\Actions\Club;
use ACTC\Clubs\Actions\Index;
use ACTC\Clubs\Actions\State;
use Illuminate\Support\Facades\Route;

Route::prefix('clubs')->name('clubs')->group(function () {
    Route::get('/', Index::class);
    Route::get('/{slug}/map', State::class)->name('.map');
    Route::get('/{slug}/{club:uuid}', Club::class)->name('.club');
    Route::get('/{slug}', State::class)->name('.state');
});
