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
        foreach (config('blockade.excluded') as $excludedRoute) {

            if ( ! $request->is($excludedRoute)) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * Get the response for failed or missing authentication.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFailedResponse(): SymfonyResponse
    {
        return response()->view('blockade::password', [], 401);
    }

    protected function passwordMatchesConfigured(string $password): string
    {
        return $this->getPasswordHash($password) === $this->getPasswordHash(config('blockade.password'));
    }

    protected function hashMatchesConfigured(string $hash): string
    {
        return $hash === $this->getPasswordHash(config('blockade.password'));
    }

    protected function getPasswordHash(string $password): string
    {
        return hash('sha256', $password);
    }
}
