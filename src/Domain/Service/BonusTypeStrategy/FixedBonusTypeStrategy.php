<?php

declare(strict_types=1);

namespace App\Domain\Service\BonusTypeStrategy;

use App\Domain\Entity\Department;
use App\Domain\Entity\Employee;
use App\Domain\Entity\Salary;

final class FixedBonusTypeStrategy implements BonusTypeStrategyInterface
{
    private int $yearsOfWorkAccountableToBonus = 10;

    public function calculateBonusAmount(Employee $employee, Department $department, Salary $salary): Salary
    {
        $yearsOfEmployment = $this->getYearsOfEmployment($employee);
        $bonusAmount = $department->getBonusFactor() * $yearsOfEmployment;
        $salary->setBonusSalary((int)$bonusAmount);

        return $salary;
    }

    private function getYearsOfEmployment(Employee $employee): int
    {
        $now = date_create('now');
        $employmentDate = $employee->getEmploymentDate();

        $years = (int)date_diff($employmentDate, $now)->format('%y');

        if ($years > $this->yearsOfWorkAccountableToBonus) {
            return $this->yearsOfWorkAccountableToBonus;
        }
        return $years;
    }
}
