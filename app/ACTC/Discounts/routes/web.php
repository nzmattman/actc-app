<?php

declare(strict_types=1);

use ACTC\Discounts\Actions\CheckDiscount;
use Illuminate\Support\Facades\Route;

Route::prefix('discount')->name('discount.')->middleware('auth')->group(function () {
    Route::post('/check', CheckDiscount::class)->name('check');
});
