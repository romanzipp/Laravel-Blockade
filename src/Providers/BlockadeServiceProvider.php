<?php

namespace romanzipp\Blockade\Providers;

use Illuminate\Support\ServiceProvider;
use romanzipp\Blockade\Handlers\Contracts\HandlerContract;
use romanzipp\Blockade\Services\Blockade;
use romanzipp\Blockade\Stores\Contracts\StoreContract;

class BlockadeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__) . '/../config/blockade.php' => config_path('blockade.php'),
        ], 'config');

        $this->loadViewsFrom(
            dirname(__DIR__) . '/../../views',
            'blockade'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/../config/blockade.php',
            'blockade'
        );

        $this->app->singleton(StoreContract::class, function () {
            return Blockade::getStore();
        });

        $this->app->singleton(HandlerContract::class, function () {
            return Blockade::getHandler();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Blockade::class];
    }
}
