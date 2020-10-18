<?php

namespace romanzipp\Blockade\Concerns;

trait ValidatesPassword
{
    /**
     * Check if a given plaintext password matches the configured password.
     *
     * @param string $password
     *
     * @return bool
     */
    protected function passwordMatchesConfigured(string $password): bool
    {
        return $this->getPasswordHash($password) === $this->getPasswordHash(config('blockade.password'));
    }

    /**
     * Check if a given has matches the configured password hash.
     *
     * @param string $hash
     *
     * @return bool
     */
    protected function hashMatchesConfigured(string $hash): bool
    {
        return $hash === $this->getPasswordHash(config('blockade.password'));
    }

    /**
     * Generate a hash from a given plaintext password.
     *
     * @param string $password
     *
     * @return string
     */
    protected function getPasswordHash(string $password): string
    {
        return hash('sha256', $password);
    }
}
