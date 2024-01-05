<?php

declare(strict_types=1);

namespace App\Tests\Unit\Doubles;

use App\Domain\Entity\Salary;
use App\Domain\Repository\SalaryRepositoryInterface;
use App\Tests\Doubles\Repository\SalaryInMemoryRepository;
use App\Tests\TestTemplate\SalaryRepositoryTestTemplate;

final class SalaryInMemoryRepositoryTest extends SalaryRepositoryTestTemplate
{
    private SalaryRepositoryInterface $repository;

    protected function setUp():void
    {
        parent::setUp();

        $this->repository = new SalaryInMemoryRepository();
    }

    protected function repository(): SalaryRepositoryInterface
    {
        return $this->repository;
    }

    protected function save(Salary $salary): void
    {
        $this->repository->save($salary);
    }
}