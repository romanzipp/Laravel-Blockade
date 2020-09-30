<?php

namespace romanzipp\Blockade\Test\Support;

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use romanzipp\Blockade\Http\Middleware\BlockadeMiddleware;

class Kernel extends HttpKernel
{
    protected $middleware = [
        EncryptCookies::class,
        BlockadeMiddleware::class,
    ];
}
