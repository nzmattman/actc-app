<?php

declare(strict_types=1);

namespace ACTC\Results\Providers;

use ACTC\Core\Aggregates\RouteAggregate;
use ACTC\Results\Commands\ImportResults;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ResultServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->commands([
            ImportResults::class,
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // add the routes
        app(RouteAggregate::class)
            ->addRouteFile('auth', __DIR__.'/../routes/auth.php');

        app()->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->command('import:results')->dailyAt(1);
        });
    }
}
