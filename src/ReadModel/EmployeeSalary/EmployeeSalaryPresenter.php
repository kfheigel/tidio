<?php

declare(strict_types=1);

namespace App\ReadModel\EmployeeSalary;

use App\Domain\Entity\Employee;

final class EmployeeSalaryPresenter
{
    public string $name;
    public string $surname;
    public string $departmentId;
    public string $salaryId;
    public string $employmentDate;

    public function __construct(Employee $employee)
    {
        $this->name = $employee->getName();
        $this->surname = $employee->getSurname();
        $this->departmentId = $employee->getSalaryId()->toRfc4122();
        $this->salaryId = $employee->getDepartmentId()->toRfc4122();
        $this->employmentDate = $employee->getEmploymentDate()->format('Y-m-d');
    }
}
