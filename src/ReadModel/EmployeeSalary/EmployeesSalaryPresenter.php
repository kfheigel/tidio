<?php

declare(strict_types=1);

namespace App\ReadModel\EmployeeSalary;

final class EmployeesSalaryPresenter
{
    public array $employees = [];

    public function __construct(array $employees)
    {
        foreach ($employees as $employee) {
            $this->employees[] = new EmployeeSalaryPresenter($employee);
        }
    }
}
