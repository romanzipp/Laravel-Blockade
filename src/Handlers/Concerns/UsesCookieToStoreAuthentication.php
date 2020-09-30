<?php

namespace romanzipp\Blockade\Handlers\Concerns;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

trait UsesCookieToStoreAuthentication
{
    protected function getCookieFromRequest(Request $request): ?string
    {
        return $request->cookie(
            config('blockade.stores.cookie.name')
        );
    }

    protected function buildCookie(): Cookie
    {
        return cookie(
            config('blockade.stores.name'),
            $this->getPasswordHash(
                config('blockade.password')
            ),
            config('blockade.stores.duration'),
            config('blockade.stores.path'),
            config('blockade.stores.domain')
        );
    }

    abstract protected function getPasswordHash(string $password): string;
}
