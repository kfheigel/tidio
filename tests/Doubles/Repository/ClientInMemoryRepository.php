<?php

namespace App\Tests\Doubles\Repository;

use App\Domain\Entity\Client;
use Symfony\Component\Uid\Uuid;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Domain\Repository\NonExistentEntityException;

final class ClientInMemoryRepository implements ClientRepositoryInterface
{
    private array $entities = [];

    public function save(Client $client): void
    {
        $this->entities[$client->getId()->toRfc4122()] = $client;
    }

    public function get(Uuid $uuid): Client
    {
        $client = $this->findOne($uuid);
        
        if (!$client) {
            throw new NonExistentEntityException(Client::class, $uuid->toRfc4122());
        }

        return $client;
    }

    public function findOne(Uuid $uuid): ?Client
    {
        return $this->entities[$uuid->toRfc4122()] ?? null;

    }

    public function findAll(): array
    {
        return $this->entities;
    }
}
