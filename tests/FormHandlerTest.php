<?php

namespace romanzipp\Blockade\Test;

use romanzipp\Blockade\Concerns\ValidatesPassword;
use romanzipp\Blockade\Handlers\FormHandler;

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

    public function testDenied()
    {
        $response = $this->get('/');

        $response->assertStatus(401);
        $response->assertViewIs('blockade::password-form');
    }

    public function testAuthWrongPassword()
    {
        $response = $this->post('/', [
            'blockade_password' => 'bar',
        ]);

        $response->assertStatus(401);
        $response->assertViewIs('blockade::password-form');
    }

    public function testAuthCorrectPassword()
    {
        $response = $this->post('/', [
            'blockade_password' => 'foo',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertCookie('blockade', $this->getPasswordHash('foo'));
    }
}
