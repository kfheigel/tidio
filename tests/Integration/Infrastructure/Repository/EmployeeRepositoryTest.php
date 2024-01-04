<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Repository;

use App\Domain\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use Doctrine\Persistence\ObjectManager;
use App\Infrastructure\Repository\EmployeeRepository;
use App\Domain\Repository\EmployeeRepositoryInterface;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use App\Tests\TestTemplate\EmployeeRepositoryTestTemplate;

final class EmployeeRepositoryTest extends EmployeeRepositoryTestTemplate
{
    use ReloadDatabaseTrait;
    
    private ObjectManager $em;
    private EmployeeRepositoryInterface $repository;

    protected function setUp():void
    {
        self::bootKernel();
        $container = static::getContainer();

        $em = $container->get(EntityManagerInterface::class);
        Assert::assertInstanceOf(ObjectManager::class, $em);
        $this->em = $em;

        $repository = $container->get(EmployeeRepository::class);
        Assert::assertInstanceOf(EmployeeRepositoryInterface::class, $repository);
        $this->repository = $repository;
    }

    protected function repository(): EmployeeRepositoryInterface
    {
        return $this->repository;
    }

    protected function save(Employee $employee): void
    {
        $this->repository->save($employee);
        $this->em->flush();
        $this->em->clear();
    }
}
