<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Department;
use App\Domain\Entity\Employee;
use App\Domain\Entity\Salary;
use App\Domain\Service\BonusTypeStrategy\BonusTypeStrategyInterface;

interface CalculatorInterface
{
    public function calculate(Employee $employee, Department $department, Salary $salary): Salary;
    public function setBonusTypeStrategy(string $strategy): void;
}
