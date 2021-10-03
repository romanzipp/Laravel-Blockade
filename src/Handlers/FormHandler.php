<?php

namespace romanzipp\Blockade\Handlers;

use Closure;
use Illuminate\Http\Request;
use romanzipp\Blockade\Concerns\ValidatesPassword;
use romanzipp\Blockade\Handlers\Contracts\HandlerContract;
use Spatie\Url\Url;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class FormHandler extends AbstractHandler implements HandlerContract
{
    use ValidatesPassword;
    private const INPUT_RETURN_TO = 'return_to';

    private const QUERY_ERROR = 'blockade_error';

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
        return $request->filled(config('blockade.handlers.form.input_field'))
            && $request->isMethod('POST');
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
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSuccessResponse(Request $request, Closure $next): SymfonyResponse
    {
        $response = redirect(
            $request->fullUrl()
        );

        if ($this->requestWantsToReturn($request)) {
            $response = $this->redirectBack($request);
        }

        return $this->store->storeSuccessState($request, $response);
    }

    /**
     * Get the response for failed or missing authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @param array<string, mixed> $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFailedResponse(Request $request, array $data = []): SymfonyResponse
    {
        if ($this->requestWantsToReturn($request)) {
            return $this->redirectBack($request, false);
        }

        if ($request->has(self::QUERY_ERROR)) {
            $data['message'] = trans('blockade::messages.errors.wrong_password');
        }

        return $this->displayView($request, 'blockade::password-form', $data);
    }

    /**
     * Check if the request has a "return to" field.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function requestWantsToReturn(Request $request): bool
    {
        return $request->has(self::INPUT_RETURN_TO);
    }

    /**
     * Build a redirect response.
     *
     * @param \Illuminate\Http\Request $request
     * @param bool $success
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function redirectBack(Request $request, bool $success = true)
    {
        $url = Url::fromString(
            $request->input(self::INPUT_RETURN_TO)
        );

        if ($success) {
            $url = $url->withoutQueryParameter(self::QUERY_ERROR);
        } else {
            $url = $url->withQueryParameter(self::QUERY_ERROR, '1');
        }

        return redirect()->to(
            (string) $url
        );
    }
}
