<?php

declare(strict_types=1);

namespace App\ReadModel\EmployeeSalary;

use App\Domain\Messenger\QueryFinderInterface;
use App\Domain\Repository\EmployeeRepositoryInterface;

final readonly class EmployeeSalaryFinder implements QueryFinderInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $repository
    ) {
    }

    public function __invoke(EmployeeSalaryQuery $query): EmployeesSalaryPresenter
    {
        $employees = $this->repository->findAll();

        return new EmployeesSalaryPresenter($employees);
    }
}
