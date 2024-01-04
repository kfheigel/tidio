<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Client;
use Symfony\Component\Uid\Uuid;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Domain\Repository\NonExistentEntityException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

final class ClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }
    
    public function save(Client $client): void
    {
        $this->getEntityManager()->persist($client);
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
        return $this->find($uuid);
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }
}
