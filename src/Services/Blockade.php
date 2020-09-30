<?php

namespace romanzipp\Blockade\Services;

use romanzipp\Blockade\Handlers\Contracts\HandlerContract;
use romanzipp\Blockade\Stores\Contracts\StoreContract;

final class Blockade
{
    /**
     * Determine if the blockade middleware is enabled.
     *
     * @return bool
     */
    public static function isEnabled(): bool
    {
        return config('blockade.enabled');
    }

    /**
     * Get the currently enabled blockade handler.
     *
     * @return \romanzipp\Blockade\Handlers\Contracts\HandlerContract
     */
    public static function getHandler(): HandlerContract
    {
        return app(
            config('blockade.handler')
        );
    }

    /**
     * Get the currently enabled blockade store.
     *
     * @return \romanzipp\Blockade\Stores\Contracts\StoreContract
     */
    public static function getStore(): StoreContract
    {
        return app(
            config('blockade.store')
        );
    }
}
