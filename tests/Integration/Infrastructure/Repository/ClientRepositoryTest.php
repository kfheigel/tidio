<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Repository;

use App\Domain\Entity\Client;
use PHPUnit\Framework\Assert;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use App\Infrastructure\Repository\ClientRepository;
use App\Domain\Repository\ClientRepositoryInterface;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use App\Tests\TestTemplate\ClientRepositoryTestTemplate;

final class ClientRepositoryTest extends ClientRepositoryTestTemplate
{
    use ReloadDatabaseTrait;
    
    private ObjectManager $em;
    private ClientRepositoryInterface $repository;

    protected function setUp():void
    {
        self::bootKernel();
        $container = static::getContainer();

        $em = $container->get(EntityManager::class);
        Assert::assertInstanceOf(ObjectManager::class, $em);
        $this->em = $em;

        $repository = $container->get(ClientRepository::class);
        Assert::assertInstanceOf(ClientRepositoryInterface::class, $repository);
        $this->repository = $repository;
    }

    protected function repository(): ClientRepositoryInterface
    {
        return $this->repository();
    }

    protected function save(Client $client): void
    {
        $this->repository->save($client);
        $this->em->flush();
        $this->em->clear();
    }
}
