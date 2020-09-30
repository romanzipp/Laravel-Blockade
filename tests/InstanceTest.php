<?php

namespace romanzipp\Blockade\Test;

use romanzipp\Blockade\Handlers\Contracts\HandlerContract;
use romanzipp\Blockade\Handlers\FormHandler;
use romanzipp\Blockade\Handlers\QueryParameterHandler;
use romanzipp\Blockade\Stores\Contracts\StoreContract;
use romanzipp\Blockade\Stores\CookieStore;
use romanzipp\Blockade\Stores\SessionStore;

class InstanceTest extends TestCase
{
    public function testServiceContainerBinding()
    {
        config([
            'blockade.handler' => FormHandler::class,
            'blockade.store' => CookieStore::class,
        ]);

        self::assertInstanceOf(FormHandler::class, app(HandlerContract::class));
        self::assertInstanceOf(CookieStore::class, app(StoreContract::class));
    }

    public function testServiceContainerBindingNonDefault()
    {
        config([
            'blockade.handler' => QueryParameterHandler::class,
            'blockade.store' => SessionStore::class,
        ]);

        self::assertInstanceOf(QueryParameterHandler::class, app(HandlerContract::class));
        self::assertInstanceOf(SessionStore::class, app(StoreContract::class));
    }
}
