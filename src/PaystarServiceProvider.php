<?php 

namespace Mkhodroo\PaystarTest;

use Illuminate\Support\ServiceProvider;
use Mkhodroo\PaystarTest\Services\PaymentServiceInterface;
use Mkhodroo\PaystarTest\Services\PaystarPaymentService;

class PaystarServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('paystar');
        $this->app->bind(PaymentServiceInterface::class, PaystarPaymentService::class);
        $this->mergeConfigFrom(__DIR__ .'\Config\paystar.php', 'paystarconfig');
    }

    public function boot()
    {
        require __DIR__.'\routes.php';
        $this->loadViewsFrom(__DIR__.'\Views', 'paystarview');
        $this->loadMigrationsFrom(__DIR__. 'Migrations');

        $this->publishes([
            __DIR__ .'\Config\paystar.php' => config_path('paystarconfig.php'),
            __DIR__.'\Views' => base_path('resources/views/mkhodroo-paystar'),
            __DIR__. '\Migrations' => database_path('/migrations'),
        ]);
    }
}

