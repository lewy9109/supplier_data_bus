<?php

declare(strict_types=1);

namespace App\Source\Domain\Auth;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Login
{
    #[Column(type: Types::STRING, length: 255, nullable: true)]
    private string $login;

    public function __construct(string $login)
    {
        $this->login = $login;
    }

    public function changeLogin(string $login): self
    {
        return new self($login);
    }

    public function __toString(): string
    {
        return $this->login;
    }
}