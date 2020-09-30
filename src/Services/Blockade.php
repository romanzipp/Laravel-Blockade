<?php

namespace romanzipp\Blockade\Services;

use romanzipp\Blockade\Handlers\Contracts\HandlerContract;

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
}
