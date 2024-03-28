<?php

namespace App\Source\Domain\ClientPolicy;

use App\Source\Domain\AuthDataInterface;
use App\Source\Domain\ConnectionInterface;

class SFTPClient implements ConnectionInterface
{
    public function __construct(AuthDataInterface $authData)
    {
    }
}