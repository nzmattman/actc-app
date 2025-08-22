<?php

declare(strict_types=1);

namespace ACTC\Core\Providers;

use ACTC\Core\Aggregates\RouteAggregate;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RouteAggregate::class);

        parent::register();
    }

    public function map(): void
    {
        $this->mapAdminRoutes();
        $this->mapWebRoutes();
    }

    public function mapAdminRoutes(): void
    {
        Route::middleware(['web', 'auth', 'onboarded', 'verified'])
            ->group(function () {
                $routeAggregate = app(RouteAggregate::class);

                foreach ($routeAggregate->getRouteFiles('auth') as $routeFile) {
                    include $routeFile;
                }
            })
        ;
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(function () {
                $routeAggregate = app(RouteAggregate::class);

                foreach ($routeAggregate->getRouteFiles('web') as $routeFile) {
                    include $routeFile;
                }
            })
        ;
    }
}
