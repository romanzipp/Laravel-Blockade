<?php

namespace romanzipp\Blockade\Handlers;

use Illuminate\Http\Request;
use romanzipp\Blockade\Stores\Contracts\StoreContract;

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
