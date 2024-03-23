<?php

declare(strict_types=1);

namespace App\Source\Domain\Auth;

class AuthFTP implements AuthDataInterface
{
    public function __construct(
        private readonly Login $login,
        private readonly Password $password,
        private readonly Host $host,
        private readonly Port $port
    ) {
    }

    public function getLogin(): Login
    {
        return $this->login;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getHost(): Host
    {
        return $this->host;
    }

    public function getPort(): Port
    {
        return $this->port;
    }
}