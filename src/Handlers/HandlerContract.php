<?php

namespace romanzipp\Blockade\Handlers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

interface HandlerContract
{
    public function isExcludedForRequest(Request $request): bool;

    public function getFailedResponse(): SymfonyResponse;

    public function requestAttemptsAuthentication(Request $request): bool;

    public function isAuthenticated(Request $request): bool;
}
