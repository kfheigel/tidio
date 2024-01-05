<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Repository;

use App\Domain\Entity\Department;
use App\Domain\Repository\DepartmentRepositoryInterface;
use App\Infrastructure\Repository\DepartmentRepository;
use App\Tests\TestTemplate\DepartmentRepositoryTestTemplate;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use PHPUnit\Framework\Assert;

final class DepartmentRepositoryTest extends DepartmentRepositoryTestTemplate
{
    use ReloadDatabaseTrait;

    private ObjectManager $em;
    private DepartmentRepositoryInterface $repository;

    protected function setUp():void
    {
        self::bootKernel();
        $container = static::getContainer();

        $em = $container->get(EntityManagerInterface::class);
        Assert::assertInstanceOf(ObjectManager::class, $em);
        $this->em = $em;

        $repository = $container->get(DepartmentRepository::class);
        Assert::assertInstanceOf(DepartmentRepositoryInterface::class, $repository);
        $this->repository = $repository;
    }

    protected function repository(): DepartmentRepositoryInterface
    {
        return $this->repository;
    }

    protected function save(Department $department): void
    {
        $this->repository->save($department);
        $this->em->flush();
        $this->em->clear();
    }
}