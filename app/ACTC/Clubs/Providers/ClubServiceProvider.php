<?php

declare(strict_types=1);

namespace ACTC\Clubs\Providers;

use ACTC\Core\Aggregates\RouteAggregate;
use Illuminate\Support\ServiceProvider;

class ClubServiceProvider extends ServiceProvider
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
        ;
    }
}
