<?php

declare(strict_types=1);

namespace App\Source\Domain\Auth;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Password
{
    #[Column(type: Types::STRING, length: 255, nullable: true)]
    private string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function changePassword(string $password): self
    {
        return new self($password);
    }

    public function __toString(): string
    {
        return $this->password;
    }
}