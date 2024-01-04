<?php

declare(strict_types=1);

namespace App\Tests\Unit\Doubles;

use App\Domain\Entity\Employee;
use App\Domain\Repository\EmployeeRepositoryInterface;
use App\Tests\TestTemplate\EmployeeRepositoryTestTemplate;
use App\Tests\Doubles\Repository\EmployeeInMemoryRepository;

final class EmployeeInMemoryRepositoryTest extends EmployeeRepositoryTestTemplate
{    
    private EmployeeRepositoryInterface $repository;

    protected function setUp():void
    {
        parent::setUp();

        $this->repository = new EmployeeInMemoryRepository();
    }

    protected function repository(): EmployeeRepositoryInterface
    {
        return $this->repository;
    }

    protected function save(Employee $employee): void
    {
        $this->repository->save($employee);
    }
}
