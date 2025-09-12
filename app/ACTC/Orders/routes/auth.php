<?php

declare(strict_types=1);

use ACTC\Orders\Actions\Invoices\Download as InvoiceDownload;
use ACTC\Orders\Actions\Subscriptions\Index as SubscriptionIndex;
use ACTC\Orders\Actions\Subscriptions\Cancel as SubscriptionCancel;
use Illuminate\Support\Facades\Route;

Route::prefix('order')->name('order.')->group(function () {});

Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
    Route::get('/', SubscriptionIndex::class)->name('index');
    Route::post('cancel', SubscriptionCancel::class)->name('cancel');
});

Route::prefix('invoices')->name('invoices.')->group(function () {
    Route::get('/{invoiceId}', InvoiceDownload::class)->name('download');
});
