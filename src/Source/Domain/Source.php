<?php

declare(strict_types=1);

namespace App\Source\Domain;

use App\Source\Domain\Auth\AuthDataInterface;
use App\Source\Domain\Auth\Host;
use App\Source\Domain\Auth\Login;
use App\Source\Domain\Auth\Port;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use App\Source\Domain\Auth\Password;

#[Entity]
class Source
{
    #[Id, GeneratedValue, Column(type: "integer")]
    private ?int $id;

    public function __construct(
        #[Embedded(class: MethodConnection::class)] private MethodConnection $methodConnection,
        #[Embedded(class: ConnectionData::class)] private ConnectionData $connectionData
    ){
    }

    public function getMethod(): MethodConnection
    {
        return $this->methodConnection;
    }

    public function getAuthData(): AuthDataInterface
    {
        return $this->connectionData->getAuthData($this->methodConnection);
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}