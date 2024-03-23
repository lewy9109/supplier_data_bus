<?php

declare(strict_types=1);

namespace App\Source\Domain\Auth;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Host
{
    #[Column(type: Types::STRING, length: 255, nullable: true)]
    private string $host;

    public function __construct(string $host)
    {
        $this->host = $host;
    }

    public function changeHost(string $host): self
    {
        return new self($host);
    }

    public function __toString(): string
    {
        return $this->host;
    }
}