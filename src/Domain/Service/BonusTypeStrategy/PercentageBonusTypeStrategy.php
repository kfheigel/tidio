<?php

declare(strict_types=1);

namespace App\Domain\Service\BonusTypeStrategy;

use App\Domain\Entity\Department;
use App\Domain\Entity\Employee;
use App\Domain\Entity\Salary;
use App\UseCase\UpdateEmployeeSalary\UpdateEmployeeSalaryCommand;

final readonly class PercentageBonusTypeStrategy implements BonusTypeStrategyInterface
{
    public function calculateBonusAmount(Employee $employee, Department $department, Salary $salary): Salary
    {
        $percentageBonus = $department->getBonusFactor() / 100;
        $baseSalary = $salary->getBaseSalary();
        $bonusAmount = $baseSalary * $percentageBonus;
        $salary->setBonusSalary((int)$bonusAmount);

        return $salary;
    }
}
