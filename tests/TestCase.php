<?php

namespace romanzipp\Blockade\Test;

use Orchestra\Testbench\TestCase as BaseTestCase;
use romanzipp\Blockade\Providers\BlockadeServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            BlockadeServiceProvider::class,
        ];
    }
}
