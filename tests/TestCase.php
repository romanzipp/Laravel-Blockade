<?php

namespace romanzipp\Blockade\Test;

use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase as BaseTestCase;
use romanzipp\Blockade\Http\Middleware\BlockadeMiddleware;
use romanzipp\Blockade\Providers\BlockadeServiceProvider;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config([
            'app.debug' => true,
            'app.key' => 'base64:' . base64_encode(Encrypter::generateKey($this->app['config']['app.cipher'])),
        ]);

        $this
            ->app['router']
            ->get('/', function (Request $request) {
                return 'Hello World';
            })
            ->middleware(['web', BlockadeMiddleware::class]);
    }

    protected function getPackageProviders($app)
    {
        return [
            BlockadeServiceProvider::class,
        ];
    }
}
