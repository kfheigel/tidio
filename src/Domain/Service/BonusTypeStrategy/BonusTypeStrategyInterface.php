<?php

declare(strict_types=1);

namespace App\Domain\Service\BonusTypeStrategy;

use App\Domain\Entity\Department;
use App\Domain\Entity\Employee;
use App\Domain\Entity\Salary;

interface BonusTypeStrategyInterface
{
    public function calculateBonusAmount(Employee $employee, Department $department, Salary $salary): Salary;
}
