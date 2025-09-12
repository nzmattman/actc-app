<?php

declare(strict_types=1);

namespace ACTC\Core\Providers;

use ACTC\Clubs\Providers\ClubServiceProvider;
use ACTC\Core\Aggregates\RouteAggregate;
use ACTC\Core\Commands\CreateModule;
use ACTC\Dashboard\Providers\DashboardServiceProvider;
use ACTC\Users\Providers\UserServiceProvider;
use ACTC\Users\User;
use ACTC\Discounts\Providers\DiscountServiceProvider;
use ACTC\Orders\Providers\OrderServiceProvider;
use ACTC\Results\Providers\ResultServiceProvider;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Cashier::useCustomerModel(User::class);
        Cashier::calculateTaxes();

        // register the service providers
		$this->app->register(ResultServiceProvider::class);
		$this->app->register(OrderServiceProvider::class);
		$this->app->register(DiscountServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
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
