<?php

declare(strict_types=1);

use ACTC\Results\Actions\Division;
use ACTC\Results\Actions\Index;
use ACTC\Results\Actions\State;
use Illuminate\Support\Facades\Route;

Route::prefix('results')->name('results')->group(function () {
    Route::get('/', Index::class);
    Route::get('/{slug}/{competition:uuid}/{section}/{division}', Division::class)->name('.division');
    Route::get('/{slug}', State::class)->name('.state');
});
