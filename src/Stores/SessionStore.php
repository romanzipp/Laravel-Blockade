<?php

namespace romanzipp\Blockade\Stores;

use Illuminate\Http\Request;
use romanzipp\Blockade\Concerns\ValidatesPassword;
use romanzipp\Blockade\Stores\Contracts\StoreContract;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SessionStore extends AbstractStore implements StoreContract
{
    use ValidatesPassword;

    public function getHash(Request $request): ?string
    {
        return $request->session()->get(
            config('blockade.stores.session.key')
        );
    }

    public function storeSuccessState(Request $request, SymfonyResponse $response): SymfonyResponse
    {
        $request->session()->put(
            config('blockade.stores.session.key'),
            $this->getPasswordHash(
                config('blockade.password')
            )
        );

        return $response;
    }
}
