<?php

declare(strict_types=1);

use App\Source\Domain\ConnectionInterface;
use App\Source\Domain\Source;
use App\Source\Domain\SourceBuilder;

class ConnectionService
{
    public function __construct(
        private SourceBuilder $builder
    ) {
    }

    public function getConnect(){
        $id = 10;
//        $source = $this->sourceRepository->getSourceById($id);
//        try {
//            $client = $this->getClient($source);
//        } catch (Exception $e) {
//
//        }
    }

    /**
     * @throws Exception
     */
    private function getClient(Source $source): ConnectionInterface
    {
        return $this->builder
            ->setSource($source)
            ->createSource();
    }
}