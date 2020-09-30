<?php

namespace romanzipp\Blockade\Providers;

use Illuminate\Support\ServiceProvider;

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
    }
}
