<?php

namespace App\Source\Domain;

use App\Source\Domain\AuthDataInterface;

class SFTPClient implements ConnectionInterface
{
    public function __construct(AuthDataInterface $authData)
    {
    }
}