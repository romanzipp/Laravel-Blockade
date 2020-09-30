<?php

namespace romanzipp\Blockade\Test;

use romanzipp\Blockade\Handlers\QueryParameterHandler;

class QueryParameterHandlerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config([
            'blockade.enabled' => true,
            'blockade.password' => 'foo',
            'blockade.handler' => QueryParameterHandler::class,
        ]);
    }

    public function testDenied()
    {
        $response = $this->get('/');

        $response->assertStatus(401);
        $response->assertViewIs('blockade::denied');
    }

    public function testAuthWrongPassword()
    {
        $response = $this->get('/?blockade_password=bar');

        $response->assertStatus(401);
        $response->assertViewIs('blockade::denied');
        $response->assertViewHas('message');
    }

    public function testAuthCorrectPassword()
    {
        $response = $this->get('/?blockade_password=foo');

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function testAuthCorrectPasswordPreserveOtherParameters()
    {
        $response = $this->get('/?foo=foo&blockade_password=foo&bar=bar');

        $response->assertStatus(302);
        $response->assertRedirect('/?foo=foo&bar=bar');
    }
}
