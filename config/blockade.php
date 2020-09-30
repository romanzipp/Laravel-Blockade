<?php

return [

    /**
     * Decide if the authentication package should be enabled.
     */
    'enabled' => env('BLOCKADE_ENABLED', false),

    /**
     * Set the password used for the authentication process.
     */
    'password' => env('BLOCKADE_PASSWORD', null),

    /**
     * Define which routes should be excluded for blockade check.
     */
    'excluded' => [],

    /**
     * Specify the authentication handler used for granting access.
     *
     * Available handlers:
     *
     * @see \romanzipp\Blockade\Handlers\FormHandler
     * @see \romanzipp\Blockade\Handlers\QueryParameterHandler
     */
    'handler' => \romanzipp\Blockade\Handlers\FormHandler::class,

    /**
     * Specify where to store the authentication state.
     *
     * Available stores:
     *
     * @see \romanzipp\Blockade\Stores\CookieStore
     * @see \romanzipp\Blockade\Stores\SessionStore
     */
    'store' => \romanzipp\Blockade\Stores\CookieStore::class,

    'branding' => [

        /**
         * Set the title displayed on the blockade view.
         */
        'title' => 'Under Construction',

        /**
         * Set a custom logo url.
         */
        'logo_url' => null,
    ],

    /**
     * Specify options for each handler.
     */
    'handlers' => [

        /**
         * @see \romanzipp\Blockade\Handlers\FormHandler
         */
        'form' => [

            /**
             * The input field provided from the view.
             */
            'input_field' => 'blockade_password',

        ],

        /**
         * @see \romanzipp\Blockade\Handlers\QueryParameterHandler
         */
        'query' => [

            /**
             * The query parameter to look for.
             */
            'parameter' => 'blockade_password',
        ],

    ],

    /**
     * Stores define where to store a successful authentication state.
     */
    'stores' => [

        /**
         * @see \romanzipp\Blockade\Stores\CookieStore
         */
        'cookie' => [

            'name' => env('BLOCKADE_COOKIE_NAME', 'blockade'),

            'domain' => env('BLOCKADE_COOKIE_DOMAIN'),

            'duration' => 60 * 24 * 7,

            'path' => null,

        ],

        /**
         * @see \romanzipp\Blockade\Stores\SessionStore
         */
        'session' => [

            'key' => env('BLOCKADE_SESSION_KEY', 'blockade_hash'),

        ],

    ],

];
