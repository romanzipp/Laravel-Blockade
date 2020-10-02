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
            __DIR__ . '/../../config/blockade.php' => config_path('blockade.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../resources/assets' => public_path('vendor/blockade'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/blockade'),
        ], 'lang');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'blockade');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'blockade');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/routes.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/blockade.php', 'blockade');

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
