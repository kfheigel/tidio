<?php

declare(strict_types=1);

namespace App\ReadModel\EmployeeSalary;

use App\Domain\Messenger\MessageBus\QueryInterface;

final class EmployeeSalaryQuery implements QueryInterface
{
    public function __construct()
    {
    }
}
