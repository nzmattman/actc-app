<?php

declare(strict_types=1);

namespace ACTC\Users\Providers;

use ACTC\Core\Aggregates\RouteAggregate;
use ACTC\Users\Listeners\StripeSubscriptionCancelled;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Events\WebhookReceived;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // add the routes
        app(RouteAggregate::class)
            ->addRouteFile('auth', __DIR__.'/../routes/auth.php')
            ->addRouteFile('web', __DIR__.'/../routes/web.php')
        ;

        Event::listen(WebhookReceived::class, StripeSubscriptionCancelled::class);
    }
}
