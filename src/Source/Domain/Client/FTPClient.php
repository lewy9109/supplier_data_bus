<?php

namespace App\Source\Domain;

use App\Source\Domain\AuthDataInterface;

class FTPClient implements ConnectionInterface
{
    public function __construct(AuthDataInterface $authData)
    {
    }
}