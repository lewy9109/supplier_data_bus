<?php

namespace App\Source\Domain\ClientPolicy;

use App\Source\Domain\AuthDataInterface;
use App\Source\Domain\ConnectionInterface;

class FTPClient implements ConnectionInterface
{
    public function __construct(AuthDataInterface $authData)
    {
    }
}