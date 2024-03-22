<?php

namespace App\Source\Domain;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class ConnectionData
{
    #[Column(type: Types::STRING, length: 255, nullable: true)]
    private string $login;

    #[Column(type: Types::STRING, length: 255, nullable: true)]
    private string $password;

    #[Column(type: Types::STRING, length: 255, nullable: true)]
    private string $url;

    #[Column(type: Types::STRING, length: 50, nullable: true)]
    private string $host;

    #[Column(type: Types::STRING, length: 2, nullable: true)]
    private string $port;

    #[Column(type: Types::STRING, length: 100, nullable: true)]
    private string $wsdl;

    #[Column(type: Types::STRING, length: 100, nullable: true)]
    private string $method;

    public function __construct(
        private MethodConnection $methodConnection,
        string $login,
        string $password,
        string $url,
        string $host,
        string $port,
        string $wsdl,
        string $method
    )
    {
        $this->login = $login;

    }

    public function getAuthData(): AuthDataInterface
    {
        return match ($this->methodConnection->toString()) {
            MethodConnection::FTP => new AuthFTP($this->login, $this->password, $this->host, $this->port),
            MethodConnection::SFTP => new AuthSFTP($this->login, $this->password, $this->host, $this->port),
            MethodConnection::URL => new AuthUrl($this->login, $this->password, $this->url),
            MethodConnection::SOAP => new AuthSOAP($this->login, $this->password, $this->wsdl, $this->method),
        };
    }

}