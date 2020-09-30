<?php

namespace romanzipp\Blockade\Test;

use romanzipp\Blockade\Concerns\ValidatesPassword;

class PasswordTest extends TestCase
{
    use ValidatesPassword;

    public function testBasicHashing()
    {
        config(['blockade.password' => 'foo']);

        self::assertEquals('2c26b46b68ffc68ff99b453c1d30413413422d706483bfa0f98a5e886266e7ae', $this->getPasswordHash('foo'));
    }

    public function testPasswordValidation()
    {
        config(['blockade.password' => 'foo']);

        self::assertTrue($this->passwordMatchesConfigured('foo'));

        self::assertFalse($this->passwordMatchesConfigured(' '));
        self::assertFalse($this->passwordMatchesConfigured(''));
        self::assertFalse($this->passwordMatchesConfigured('bar'));
        self::assertFalse($this->passwordMatchesConfigured(' foo'));
        self::assertFalse($this->passwordMatchesConfigured('foo '));
    }

    public function testHashValidation()
    {
        config(['blockade.password' => 'foo']);

        self::assertTrue($this->hashMatchesConfigured('2c26b46b68ffc68ff99b453c1d30413413422d706483bfa0f98a5e886266e7ae'));

        self::assertFalse($this->hashMatchesConfigured(''));
        self::assertFalse($this->hashMatchesConfigured(' 2c26b46b68ffc68ff99b453c1d30413413422d706483bfa0f98a5e886266e7ae'));
        self::assertFalse($this->hashMatchesConfigured('2c26b46b68ffc68ff99b453c1d30413413422d706483bfa0f98a5e886266e7ae '));
    }
}
