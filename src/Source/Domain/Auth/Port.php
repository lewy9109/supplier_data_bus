<?php

declare(strict_types=1);

namespace App\Source\Domain\Auth;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Port
{
    #[Column(type: Types::STRING, length: 255, nullable: true)]
    private string $port;

    public function __construct(string $port)
    {
        $this->port = $port;
    }

    public function changePassword(string $port): self
    {
        return new self($port);
    }

    public function __toString(): string
    {
        return $this->port;
    }
}