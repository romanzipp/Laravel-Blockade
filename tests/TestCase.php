<?php

namespace romanzipp\Blockade\Test;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as BaseTestCase;
use romanzipp\Blockade\Http\Middleware\BlockadeMiddleware;
use romanzipp\Blockade\Providers\BlockadeServiceProvider;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Route::middleware([BlockadeMiddleware::class])->group(function () {
            Route::get('/', function (Request $request) {
                return 'Hello World';
            });
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            BlockadeServiceProvider::class,
        ];
    }
}
