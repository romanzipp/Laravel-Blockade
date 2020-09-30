<?php

namespace romanzipp\Blockade\Test;

use romanzipp\Blockade\Concerns\ValidatesPassword;
use romanzipp\Blockade\Handlers\QueryParameterHandler;
use romanzipp\Blockade\Stores\CookieStore;
use romanzipp\Blockade\Stores\SessionStore;

class QueryParameterHandlerTest extends TestCase
{
    use ValidatesPassword;

    public function setUp(): void
    {
        parent::setUp();

        config([
            'blockade.enabled' => true,
            'blockade.password' => 'foo',
            'blockade.handler' => QueryParameterHandler::class,
        ]);
    }

    /*
     *--------------------------------------------------------------------------
     * Cookie Store
     *--------------------------------------------------------------------------
     */

    public function testCookieStoreDenied()
    {
        config(['blockade.store' => CookieStore::class]);

        $response = $this->get('/');

        $response->assertStatus(401);
        $response->assertViewIs('blockade::denied');
    }

    public function testCookieStoreAuthWrongPassword()
    {
        config(['blockade.store' => CookieStore::class]);

        $response = $this->get('/?blockade_password=bar');

        $response->assertStatus(401);
        $response->assertViewIs('blockade::denied');
        $response->assertViewHas('message');
    }

    public function testCookieStoreAuthCorrectPassword()
    {
        config(['blockade.store' => CookieStore::class]);

        $response = $this->get('/?blockade_password=foo');

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertCookie('blockade', $this->getPasswordHash('foo'));
    }

    public function testCookieStoreAuthCorrectPasswordPreserveOtherParameters()
    {
        config(['blockade.store' => CookieStore::class]);

        $response = $this->get('/?foo=foo&blockade_password=foo&bar=bar');

        $response->assertStatus(302);
        $response->assertRedirect('/?foo=foo&bar=bar');
        $response->assertCookie('blockade', $this->getPasswordHash('foo'));
    }

    /*
     *--------------------------------------------------------------------------
     * Session Store
     *--------------------------------------------------------------------------
     */

    public function testSessionStoreDenied()
    {
        config(['blockade.store' => SessionStore::class]);

        $response = $this->get('/');

        $response->assertStatus(401);
        $response->assertViewIs('blockade::denied');
    }

    public function testSessionStoreAuthWrongPassword()
    {
        config(['blockade.store' => SessionStore::class]);

        $response = $this->get('/?blockade_password=bar');

        $response->assertStatus(401);
        $response->assertViewIs('blockade::denied');
        $response->assertViewHas('message');
    }

    public function testSessionStoreAuthCorrectPassword()
    {
        config(['blockade.store' => SessionStore::class]);

        $response = $this->get('/?blockade_password=foo');

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('blockade_hash', $this->getPasswordHash('foo'));
    }

    public function testSessionStoreAuthCorrectPasswordPreserveOtherParameters()
    {
        config(['blockade.store' => SessionStore::class]);

        $response = $this->get('/?foo=foo&blockade_password=foo&bar=bar');

        $response->assertStatus(302);
        $response->assertRedirect('/?foo=foo&bar=bar');
        $response->assertSessionHas('blockade_hash', $this->getPasswordHash('foo'));
    }
}
