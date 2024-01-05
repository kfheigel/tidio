<?php

declare(strict_types=1);

namespace App\ReadModel\EmployeesPayroll;

use App\Domain\Messenger\QueryFinderInterface;
use App\Domain\Repository\DepartmentRepositoryInterface;
use App\Domain\Repository\EmployeeRepositoryInterface;
use App\Domain\Repository\SalaryRepositoryInterface;
use App\Infrastructure\Service\EmployeeDataMerger;

final readonly class EmployeesPayrollFinder implements QueryFinderInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $repository,
        private EmployeeDataMerger $dataMerger
    ) {
    }

    public function __invoke(EmployeesPayrollQuery $query): array
    {
        $employeesPayroll = [];
        $employees =  $this->repository->findAll();

        foreach ($employees as $employee) {
            $employeesPayroll[] = $this->dataMerger->merge($employee);
        }

        return $employeesPayroll;
    }
}
