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
     * Specify the title displayed on the blockade view.
     */
    'title' => 'Under Construction',

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
         * The cookie stores saves the password hash as a browser cookie.
         */
        'cookie' => [

            'name' => env('BLOCKADE_COOKIE_NAME', 'blockade'),

            'domain' => env('BLOCKADE_COOKIE_DOMAIN', env('APP_URL')),

            'duration' => 60 * 24 * 7,

            'path' => null,

        ],

    ],

];
