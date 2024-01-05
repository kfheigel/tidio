<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Employee;
use App\Domain\Repository\DepartmentRepositoryInterface;
use App\Domain\Repository\SalaryRepositoryInterface;
use App\Domain\Service\CalculatorInterface;

final readonly class EmployeeDataMerger
{
    public function __construct(
        private SalaryRepositoryInterface $salaryRepository,
        private DepartmentRepositoryInterface $departmentRepository,
        private CalculatorInterface $calculator
    ) {
    }

    public function merge(Employee $employee): array
    {
        $department = $this->departmentRepository->get($employee->getDepartmentId());
        $bonusType = $department->getBonusType()->value;
        $this->calculator->setBonusTypeStrategy($bonusType);

        $salary = $this->salaryRepository->get($employee->getSalaryId());

        if (!$salary->getBonusSalary()) {
            $salary = $this->calculator->calculate($employee, $department, $salary);
        }

        return array_merge($employee->toArray(), $department->toArray(), $salary->toArray());
    }
}
