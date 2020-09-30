<?php

namespace romanzipp\Blockade\Test;

use romanzipp\Blockade\Concerns\ValidatesPassword;
use romanzipp\Blockade\Handlers\FormHandler;
use romanzipp\Blockade\Stores\CookieStore;
use romanzipp\Blockade\Stores\SessionStore;

class FormHandlerTest extends TestCase
{
    use ValidatesPassword;

    public function setUp(): void
    {
        parent::setUp();

        config([
            'blockade.enabled' => true,
            'blockade.password' => 'foo',
            'blockade.handler' => FormHandler::class,
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
        $response->assertViewIs('blockade::password-form');
    }

    public function testCookieStoreAuthWrongPassword()
    {
        config(['blockade.store' => CookieStore::class]);

        $response = $this->post('/', [
            'blockade_password' => 'bar',
        ]);

        $response->assertStatus(401);
        $response->assertViewIs('blockade::password-form');
        $response->assertViewHas('message');
    }

    public function testCookieStoreAuthCorrectPassword()
    {
        config(['blockade.store' => CookieStore::class]);

        $response = $this->post('/', [
            'blockade_password' => 'foo',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
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
        $response->assertViewIs('blockade::password-form');
    }

    public function testSessionStoreAuthWrongPassword()
    {
        config(['blockade.store' => SessionStore::class]);

        $response = $this->post('/', [
            'blockade_password' => 'bar',
        ]);

        $response->assertStatus(401);
        $response->assertViewIs('blockade::password-form');
        $response->assertViewHas('message');
    }

    public function testSessionStoreAuthCorrectPassword()
    {
        config(['blockade.store' => SessionStore::class]);

        $response = $this->post('/', [
            'blockade_password' => 'foo',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('blockade_hash', $this->getPasswordHash('foo'));
    }
}
