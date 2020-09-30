<?php

namespace romanzipp\Blockade\Handlers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class AbstractHandler
{
    protected function getExcludedRoutes(): array
    {
        return config('blockade.excluded');
    }

    public function isExcludedForRequest(Request $request): bool
    {
        foreach ($this->getExcludedRoutes() as $excludedRoute) {

            if ( ! $request->is($excludedRoute)) {
                continue;
            }

            return true;
        }

        return false;
    }

    public function getFailedResponse(): SymfonyResponse
    {
        return response()->view('blockade::password', [], 401);
    }
}
