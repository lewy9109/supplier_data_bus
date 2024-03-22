<?php

declare(strict_types=1);

namespace App\Source\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class MethodConnection
{
    public const FTP = 'FTP';
    public const SFTP = 'SFTP';
    public const URL = 'URL';
    public const SOAP = 'SOAP';

    #[Column(type: "string", length: 50)]
    private string $method;

    private function __construct(string $method)
    {
        $this->method = $method;
    }

    public static function SFTP(): self
    {
        return new self(self::SFTP);
    }

    public static function FTP(): self
    {
        return new self(self::FTP);
    }

    public static function URL(): self
    {
        return new self(self::URL);
    }

    public static function SOAP(): self
    {
        return new self(self::SOAP);
    }

    public function toString(): string
    {
        return $this->method;
    }
}