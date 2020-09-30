<?php

namespace romanzipp\Blockade\Concerns;

trait ValidatesPassword
{
    protected function passwordMatchesConfigured(string $password): string
    {
        return $this->getPasswordHash($password) === $this->getPasswordHash(config('blockade.password'));
    }

    protected function hashMatchesConfigured(string $hash): string
    {
        return $hash === $this->getPasswordHash(config('blockade.password'));
    }

    protected function getPasswordHash(string $password): string
    {
        return hash('sha256', $password);
    }
}
