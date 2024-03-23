<?php

declare(strict_types=1);

namespace App\Source\Domain;

class SourceFactory
{
    public function __construct(
        private readonly Source $source
    )
    {
    }

    public function createSource(): ConnectionInterface
    {
        return match ($this->source->getMethod()->toString()) {
            MethodConnection::FTP => $this->createFTPClient(),
            MethodConnection::SFTP => $this->createSFTPClient(),
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