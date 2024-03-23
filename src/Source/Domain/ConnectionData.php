<?php

declare(strict_types=1);

namespace App\Source\Domain;

use App\Source\Domain\Auth\AuthDataInterface;
use App\Source\Domain\Auth\AuthFTP;
use App\Source\Domain\Auth\AuthSFTP;
use App\Source\Domain\Auth\Host;
use App\Source\Domain\Auth\Login;
use App\Source\Domain\Auth\Password;
use App\Source\Domain\Auth\Port;
use Doctrine\ORM\Mapping\Embeddable;
use Doctrine\ORM\Mapping\Embedded;

#[Embeddable]
class ConnectionData
{
    #[Embedded(class: Login::class)]
    private ?Login $login;

    #[Embedded(class: Password::class)]
    private ?Password $password;

    #[Embedded(class: Host::class)]
    private ?Host $host;

    #[Embedded(class: Port::class)]
    private ?Port $port;

    public function __construct(
        ?Login $login = null,
        ?Password $password = null,
        ?Host $host = null,
        ?Port $port = null,
    )
    {
        $this->login = $login;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;

    }

    public function getAuthData(MethodConnection $methodConnection): AuthDataInterface
    {
        return match ($methodConnection->toString()) {
            MethodConnection::FTP => new AuthFTP($this->login, $this->password, $this->host, $this->port),
            MethodConnection::SFTP => new AuthSFTP($this->login, $this->password, $this->host, $this->port),
        };
    }

}