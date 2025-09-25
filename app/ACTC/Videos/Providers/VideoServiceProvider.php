<?php

declare(strict_types=1);

namespace ACTC\Videos\Providers;

use ACTC\Core\Aggregates\RouteAggregate;
use Illuminate\Support\ServiceProvider;

class VideoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

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
