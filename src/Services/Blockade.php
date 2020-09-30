<?php

namespace romanzipp\Blockade\Services;

use romanzipp\Blockade\Handlers\HandlerContract;

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
     * @return \romanzipp\Blockade\Handlers\HandlerContract
     */
    public static function getHandler(): HandlerContract
    {
        return app(
            config('blockade.handler')
        );
    }
}
