<?php

namespace ACTC\Orders\Actions\Subscriptions;

use ACTC\Orders\Resources\InvoiceResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Cashier\Cashier;
use NumberFormatter;

class Index
{
    public function __invoke(Request $request): Response
    {
        $user = $request->user();

        $config = [
            'invoices' => Inertia::defer(function () use ($user) {
                $invoices = $user->invoices()->filter(function ($invoice) {
                    $stripeInvoice = $invoice->asStripeInvoice();

                    return isset($stripeInvoice->subscription) && $stripeInvoice->subscription;
                });

                return InvoiceResource::collection($invoices)->resolve();
            }, 'invoices'),
            'subscription' => Inertia::defer(function () use ($user) {
                $subscription = $user->subscription('main');
                // get further info on the subscription
                $stripe = Cashier::stripe();
                $prices = $stripe->prices->retrieve($subscription->stripe_price, [
                    'expand' => ['product'],
                ]);

                $formatter = new NumberFormatter('en_AU', NumberFormatter::CURRENCY);

                return [
                    'name' => $prices->product->name ?? 'Subscription',
                    'price' => $formatter->formatCurrency($prices->unit_amount / 100, 'AUD'),
                    'frequency' => $prices->recurring->interval,
                ];
            }, 'subscription'),
        ];

        return Inertia::render('Subscriptions/Index', $config);
    }
}
