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
     * @see \romanzipp\Blockade\Handlers\Contracts\HandlerContract
     */
    'handler' => \romanzipp\Blockade\Handlers\FormHandler::class,

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
            'input_field' => 'blockage_password',

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
