<?php

namespace romanzipp\Blockade\Handlers;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

interface HandlerContract
{
    /**
     * Check if the current request is excluded for blockade authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function isExcludedForRequest(Request $request): bool;

    /**
     * Check if the current request is already authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function isAuthenticated(Request $request): bool;

    /**
     * Check if the current request is attempting authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function requestAttemptsAuthentication(Request $request): bool;

    /**
     * Attempt the blockade authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function attemptAuthentication(Request $request): bool;

    /**
     * Store the successful authentication state and return a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSuccessResponse(Request $request, Closure $next): SymfonyResponse;

    /**
     * Get the response for failed or missing authentication.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFailedResponse(): SymfonyResponse;
}
