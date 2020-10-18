<?php

namespace romanzipp\Blockade\Stores;

use Illuminate\Http\Request;
use romanzipp\Blockade\Concerns\ValidatesPassword;
use romanzipp\Blockade\Stores\Contracts\StoreContract;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SessionStore extends AbstractStore implements StoreContract
{
    use ValidatesPassword;

    /**
     * Get the password hash for the given request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string|null
     */
    public function getHash(Request $request): ?string
    {
        return $request->session()->get(
            config('blockade.stores.session.key')
        );
    }

    /**
     * Store the success state for the request and return a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse $response
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function storeSuccessState(Request $request, $response): SymfonyResponse
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
