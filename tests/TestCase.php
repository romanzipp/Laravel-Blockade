<?php

namespace romanzipp\Blockade\Test;

use Illuminate\Contracts\Http\Kernel as BaseKernel;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase as BaseTestCase;
use romanzipp\Blockade\Providers\BlockadeServiceProvider;
use romanzipp\Blockade\Test\Support\Kernel;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config([
            'app.debug' => true,
            'app.key' => 'base64:' . base64_encode(Encrypter::generateKey($this->app['config']['app.cipher'])),
        ]);

        $this->app->singleton(BaseKernel::class, Kernel::class);

        $this->app['router']->get('/', function (Request $request) {
            return 'Hello World';
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            BlockadeServiceProvider::class,
        ];
    }
}
