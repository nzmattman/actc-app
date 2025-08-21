<?php

declare(strict_types=1);

namespace ACTC\Core\Providers;

use ACTC\Clubs\Providers\ClubServiceProvider;
use ACTC\Core\Aggregates\RouteAggregate;
use ACTC\Core\Commands\CreateModule;
use ACTC\Dashboard\Providers\DashboardServiceProvider;
use ACTC\Profile\Providers\ProfileServiceProvider;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // register the service providers
		$this->app->register(ProfileServiceProvider::class);
        $this->app->register(DashboardServiceProvider::class);
        $this->app->register(ClubServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        // register the global commands
        $this->commands([
            CreateModule::class,
        ]);

        // add the routes
        app(RouteAggregate::class)
            ->addRouteFile('web', __DIR__.'/../routes/web.php')
        ;
    }
}
