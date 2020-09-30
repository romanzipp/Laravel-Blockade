<?php

namespace romanzipp\Blockade\Handlers;

use Illuminate\Http\Request;
use romanzipp\Blockade\Stores\Contracts\StoreContract;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class AbstractHandler
{
    /**
     * @var \romanzipp\Blockade\Stores\Contracts\StoreContract
     */
    protected $store;

    public function __construct(StoreContract $store)
    {
        $this->store = $store;
    }

    /**
     * Check if the current request is excluded for blockade authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function isExcludedForRequest(Request $request): bool
    {
        return $request->is(...config('blockade.excluded'))
            || $request->routeIs(...config('blockade.excluded'));
    }

    /**
     * Render the failed view and attach the current url for redirect.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $view
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function displayView(Request $request, string $view, array $data = []): SymfonyResponse
    {
        $data['returnTo'] = $request->url();

        return response()->view($view, $data, 401);
    }
}
