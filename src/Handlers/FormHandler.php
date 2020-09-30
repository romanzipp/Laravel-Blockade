<?php

namespace romanzipp\Blockade\Handlers;

use Closure;
use Illuminate\Http\Request;
use romanzipp\Blockade\Handlers\Concerns\UsesCookieToStoreAuthentication;
use romanzipp\Blockade\Handlers\Contracts\HandlerContract;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class FormHandler extends AbstractHandler implements HandlerContract
{
    use UsesCookieToStoreAuthentication;

    /**
     * Check if the current request is already authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function isAuthenticated(Request $request): bool
    {
        $cookie = $this->getCookieFromRequest($request);

        if ( ! $cookie) {
            return false;
        }

        return $this->hashMatchesConfigured($cookie);
    }

    /**
     * Check if the current request is attempting authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function requestAttemptsAuthentication(Request $request): bool
    {
        if ( ! $request->filled(config('blockade.handlers.form.input_field'))) {
            return false;
        }

        if ($request->getMethod() !== 'POST') {
            return false;
        }

        return true;
    }

    /**
     * Attempt the blockade authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function attemptAuthentication(Request $request): bool
    {
        $password = $request->input(
            config('blockade.handlers.form.input_field')
        );

        if (empty($password)) {
            return false;
        }

        if ( ! $this->passwordMatchesConfigured($password)) {
            return false;
        }

        return true;
    }

    /**
     * Store the successful authentication state and return a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSuccessResponse(Request $request, Closure $next): SymfonyResponse
    {
        $response = redirect(
            $request->fullUrl()
        );

        return $response->withCookie(
            $this->buildCookie()
        );
    }
}
