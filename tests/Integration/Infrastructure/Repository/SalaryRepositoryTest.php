<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Repository;

use App\Domain\Entity\Salary;
use App\Domain\Repository\SalaryRepositoryInterface;
use App\Infrastructure\Repository\SalaryRepository;
use App\Tests\TestTemplate\SalaryRepositoryTestTemplate;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use PHPUnit\Framework\Assert;

final class SalaryRepositoryTest extends SalaryRepositoryTestTemplate
{
    use ReloadDatabaseTrait;

    private ObjectManager $em;
    private SalaryRepositoryInterface $repository;

    protected function setUp():void
    {
        self::bootKernel();
        $container = static::getContainer();

        $em = $container->get(EntityManagerInterface::class);
        Assert::assertInstanceOf(ObjectManager::class, $em);
        $this->em = $em;

        $repository = $container->get(SalaryRepository::class);
        Assert::assertInstanceOf(SalaryRepositoryInterface::class, $repository);
        $this->repository = $repository;
    }

    protected function repository(): SalaryRepositoryInterface
    {
        return $this->repository;
    }

    protected function save(Salary $salary): void
    {
        $this->repository->save($salary);
        $this->em->flush();
        $this->em->clear();
    }
}
