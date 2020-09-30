<?php

namespace romanzipp\Blockade\Stores\Contracts;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

interface StoreContract
{
    /**
     * Get the password hash for the given request.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function getHash(Request $request): ?string;

    /**
     * Store the success state for the request and return a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function storeSuccessState(Request $request, $response): SymfonyResponse;
}
