<?php

namespace romanzipp\Blockade\Providers;

use Illuminate\Support\ServiceProvider;
use romanzipp\Blockade\Http\Middleware\BlockadeMiddleware;
use romanzipp\Blockade\Services\Blockade;

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
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/../config/blockade.php', 'blockade'
        );

        $this->app->singleton(BlockadeMiddleware::class, function () {
            return new BlockadeMiddleware(
                Blockade::getHandler()
            );
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
