<?php

declare(strict_types=1);

namespace App\Source\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Source
{
    #[Id, GeneratedValue, Column(type: "integer")]
    private int $id;

    #[Embedded(class: MethodConnection::class)]
    private MethodConnection $methodConnection;

    #[Embedded(class: ConnectionData::class)]
    private ConnectionData $connectionData;

}