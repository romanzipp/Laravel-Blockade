<?php

namespace romanzipp\Blockade\Handlers;

use Closure;
use Illuminate\Http\Request;
use romanzipp\Blockade\Concerns\ValidatesPassword;
use romanzipp\Blockade\Handlers\Contracts\HandlerContract;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class FormHandler extends AbstractHandler implements HandlerContract
{
    use ValidatesPassword;

    /**
     * Check if the current request is already authenticated.
     *
     * @param \Illuminate\Http\Request $request
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
     * @return bool
     */
    public function requestAttemptsAuthentication(Request $request): bool
    {
        return $request->filled(config('blockade.handlers.form.input_field'))
            && $request->isMethod('POST');
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

        return $this->passwordMatchesConfigured($password);
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

        return $this->store->storeSuccessState($request, $response);
    }

    /**
     * Get the response for failed or missing authentication.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFailedResponse(): SymfonyResponse
    {
        return response()->view('blockade::password-form', [], 401);
    }
}
