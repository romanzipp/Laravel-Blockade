<?php

namespace romanzipp\Blockade\Stores;

use Illuminate\Http\Request;
use romanzipp\Blockade\Concerns\ValidatesPassword;
use romanzipp\Blockade\Stores\Contracts\StoreContract;
use RuntimeException;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class CookieStore extends AbstractStore implements StoreContract
{
    use ValidatesPassword;

    public function getHash(Request $request): ?string
    {
        return $request->cookie(
            config('blockade.stores.cookie.name')
        );
    }

    public function storeSuccessState(Request $request, SymfonyResponse $response): SymfonyResponse
    {
        if ( ! method_exists($response, 'withCookie')) {
            throw new RuntimeException('Can not set a cookie for the current response');
        }

        /** @var $response \Illuminate\Http\Response */
        return $response->withCookie(
            $this->buildCookie()
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
}
