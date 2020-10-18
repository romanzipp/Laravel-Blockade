<?php

namespace romanzipp\Blockade\Handlers;

use Closure;
use Illuminate\Http\Request;
use romanzipp\Blockade\Concerns\ValidatesPassword;
use romanzipp\Blockade\Handlers\Contracts\HandlerContract;
use Spatie\Url\Url;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class QueryParameterHandler extends AbstractHandler implements HandlerContract
{
    use ValidatesPassword;

    /**
     * Check if the current request is already authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function isAuthenticated(Request $request): bool
    {
        if ( ! $hash = $this->store->getHash($request)) {
            return false;
        }

        return $this->hashMatchesConfigured($hash);
    }

    /**
     * Check if the current request is attempting authentication.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function requestAttemptsAuthentication(Request $request): bool
    {
        return $request->filled(config('blockade.handlers.query.parameter'))
            && $request->isMethod('GET');
    }

    /**
     * Attempt the blockade authentication.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function attemptAuthentication(Request $request): bool
    {
        $password = $request->query(
            config('blockade.handlers.query.parameter')
        );

        if (empty($password)) {
            return false;
        }

        return $this->passwordMatchesConfigured($password);
    }

    /**
     * Store the successful authentication state and return a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSuccessResponse(Request $request, Closure $next): SymfonyResponse
    {
        $response = redirect(
            Url::fromString($request->fullUrl())
                ->withoutQueryParameter(
                    config('blockade.handlers.query.parameter')
                )
        );

        return $this->store->storeSuccessState($request, $response);
    }

    /**
     * Get the response for failed or missing authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFailedResponse(Request $request, array $data = []): SymfonyResponse
    {
        return $this->displayView($request, 'blockade::denied', $data);
    }
}
