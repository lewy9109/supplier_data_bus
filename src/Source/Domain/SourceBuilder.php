<?php

declare(strict_types=1);

namespace App\Source\Domain;

use App\Source\Domain\ClientPolicy\FTPClient;
use App\Source\Domain\ClientPolicy\SFTPClient;

class SourceBuilder
{
    private ?Source $source = null;

    public function setSource(Source $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function createSource(): ConnectionInterface
    {
        return match ($this->source->getMethod()->toString()) {
            MethodConnection::FTP => $this->createFTPClient(),
            MethodConnection::SFTP => $this->createSFTPClient(),
            default => throw new \Exception('Not found source to get client')
        };
    }

    private function createFTPClient(): ConnectionInterface
    {
        return new FTPClient($this->source->getAuthData());
    }

    private function createSFTPClient(): ConnectionInterface
    {
        return new SFTPClient($this->source->getAuthData());
    }

}