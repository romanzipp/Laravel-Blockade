<?php

return [
    /*
     * Decide if the authentication package should be enabled.
     */
    'enabled' => env('BLOCKADE_ENABLED', false),

    /*
     * Set the password used for the authentication process.
     */
    'password' => env('BLOCKADE_PASSWORD', null),

    /*
     * Define which routes should be excluded for blockade check.
     * You can specify route names or paths including wildcards.
     * The routes will be check via the Request::is() and Request::routeIs() methods.
     */
    'excluded' => [],

    /*
     * Specify the authentication handler used for granting access.
     *
     * Available handlers:
     * - \romanzipp\Blockade\Handlers\FormHandler::class
     * - \romanzipp\Blockade\Handlers\QueryParameterHandler::class
     */
    'handler' => \romanzipp\Blockade\Handlers\FormHandler::class,

    /*
     * Specify where to store the authentication state.
     *
     * Available stores:
     * - \romanzipp\Blockade\Stores\CookieStore::class
     * - \romanzipp\Blockade\Stores\SessionStore::class
     */
    'store' => \romanzipp\Blockade\Stores\CookieStore::class,

    /*
     * Routing options.
     */
    'routes' => [
        'prefix' => 'blockade',

        'middleware' => [
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \romanzipp\Blockade\Http\Middleware\BlockadeMiddleware::class,
        ],
    ],

    /*
     * Branding options.
     */
    'branding' => [
        'logo_url' => null,
    ],

    /*
     * Specify options for each handler.
     */
    'handlers' => [
        /** @see \romanzipp\Blockade\Handlers\FormHandler */
        'form' => [
            'input_field' => 'blockade_password',
        ],

        /** @see \romanzipp\Blockade\Handlers\QueryParameterHandler */
        'query' => [
            'parameter' => 'blockade_password',
        ],
    ],

    /*
     * Stores define where to store a successful authentication state.
     */
    'stores' => [
        /** @see \romanzipp\Blockade\Stores\CookieStore */
        'cookie' => [
            'name' => env('BLOCKADE_COOKIE_NAME', 'blockade'),

            'domain' => env('BLOCKADE_COOKIE_DOMAIN'),

            'duration' => 60 * 24 * 7,

            'path' => null,
        ],

        /** @see \romanzipp\Blockade\Stores\SessionStore */
        'session' => [
            'key' => env('BLOCKADE_SESSION_KEY', 'blockade_hash'),
        ],
    ],
];
