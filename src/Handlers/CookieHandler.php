<?php

namespace romanzipp\Blockade\Handlers;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class CookieHandler extends AbstractHandler implements HandlerContract
{
    /**
     * Check if the current request is already authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function isAuthenticated(Request $request): bool
    {
        $cookie = $request->cookie(
            config('blockade.handlers.cookie.cookie')
        );

        if ( ! $cookie) {
            return false;
        }

        return $this->hashMatches($cookie);
    }

    /**
     * Check if the current request is attempting authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function requestAttemptsAuthentication(Request $request): bool
    {
        if ( ! $request->filled(config('blockade.handlers.cookie.input_field'))) {
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
            config('blockade.handlers.cookie.input_field')
        );

        if (empty($password)) {
            return false;
        }

        if ( ! $this->passwordMatches($password)) {
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

        $cookie = cookie(
            config('blockade.handlers.cookie.cookie'),
            $this->getPasswordHash(
                config('blockade.password')
            ),
            config('blockade.handlers.cookie.duration'),
            config('blockade.handlers.cookie.path'),
            config('blockade.handlers.cookie.domain')
        );

        return $response->withCookie($cookie);
    }

    private function passwordMatches(string $password): string
    {
        return $this->getPasswordHash($password) === $this->getPasswordHash(config('blockade.password'));
    }

    private function hashMatches(string $hash): string
    {
        return $hash === $this->getPasswordHash(config('blockade.password'));
    }

    private function getPasswordHash(string $password): string
    {
        return hash('sha256', $password);
    }
}
