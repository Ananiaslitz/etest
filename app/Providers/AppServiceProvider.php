<?php

namespace App\Providers;

use Core\Application\CommandQueryBus;
use Core\Application\CommandQueryBusInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClientInterface::class, Client::class);

        $this->app->singleton(CommandQueryBusInterface::class, function ($app) {
            $mappings = config('commandhandler.mappings');
            return new CommandQueryBus($app, $mappings);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
