<?php

declare(strict_types=1);

namespace App\Tests\Unit\Doubles;

use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Tests\TestTemplate\ClientRepositoryTestTemplate;
use App\Tests\Doubles\Repository\ClientInMemoryRepository;

final class ClientInMemoryRepositoryTest extends ClientRepositoryTestTemplate
{    
    private ClientRepositoryInterface $repository;

    protected function setUp():void
    {
        parent::setUp();

        $this->repository = new ClientInMemoryRepository();
    }

    protected function repository(): ClientRepositoryInterface
    {
        return $this->repository;
    }

    protected function save(Client $client): void
    {
        $this->repository->save($client);
    }
}
