<?php

namespace romanzipp\Blockade\Http\Middleware;

use Closure;
use romanzipp\Blockade\Handlers\HandlerContract;
use romanzipp\Blockade\Services\Blockade;

class BlockadeMiddleware
{
    /**
     * @var \romanzipp\Blockade\Handlers\HandlerContract
     */
    private $handler;

    public function __construct(HandlerContract $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! Blockade::isEnabled()) {
            return $next($request);
        }

        // Check if the current request should be skipped
        if ($this->handler->isExcludedForRequest($request)) {
            return $next($request);
        }

        // Check if the current request is already authenticated
        if ($this->handler->isAuthenticated($request)) {
            return $next($request);
        }

        // Send a failed response if the request is not attempting authentication
        if ( ! $this->handler->requestAttemptsAuthentication($request)) {
            return $this->handler->getFailedResponse();
        }

        // Attempt authenticating with the given authentication method
        if ( ! $this->handler->attemptAuthentication($request)) {
            return $this->handler->getFailedResponse();
        }

        return $this->handler->getSuccessResponse($request, $next);
    }
}
