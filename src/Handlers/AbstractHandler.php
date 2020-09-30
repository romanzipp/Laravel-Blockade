<?php

namespace romanzipp\Blockade\Handlers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class AbstractHandler
{
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
}
