<?php

namespace App\Providers;

use Core\Application\CommandQueryBus;
use Core\Application\CommandQueryBusInterface;
use Core\Application\Handler\Command\Sale\CancelCommandHandler;
use Core\Domain\Repository\ProductRepositoryInterface;
use Core\Domain\Repository\SaleRepositoryInterface;
use Core\Infrastructure\Repository\ProductRepository;
use Core\Infrastructure\Repository\SaleRepository;
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

        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
