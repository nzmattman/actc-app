<?php

declare(strict_types=1);

namespace ACTC\Core\Providers;

use ACTC\Core\Aggregates\RouteAggregate;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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
        Route::middleware(['web', 'auth', 'active', 'onboarded', 'verified', 'redirectIfAdmin'])
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

        Route::middleware(['web', 'auth'])->get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('auth.logout');
    }
}
