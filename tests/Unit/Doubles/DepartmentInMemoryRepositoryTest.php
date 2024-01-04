<?php

declare(strict_types=1);

namespace App\Tests\Unit\Doubles;

use App\Domain\Entity\Department;
use App\Domain\Repository\DepartmentRepositoryInterface;
use App\Tests\Doubles\Repository\DepartmentInMemoryRepository;
use App\Tests\TestTemplate\DepartmentRepositoryTestTemplate;

final class DepartmentInMemoryRepositoryTest extends DepartmentRepositoryTestTemplate
{
    private DepartmentRepositoryInterface $repository;

    protected function setUp():void
    {
        parent::setUp();

        $this->repository = new DepartmentInMemoryRepository();
    }

    protected function repository(): DepartmentRepositoryInterface
    {
        return $this->repository;
    }

    protected function save(Department $department): void
    {
        $this->repository->save($department);
    }
}