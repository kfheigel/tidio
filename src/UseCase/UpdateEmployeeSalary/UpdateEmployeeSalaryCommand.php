<?php

namespace App\UseCase\UpdateEmployeeSalary;

use App\Domain\Command\AsyncCommandInterface;
use App\Infrastructure\Validator\SalaryUuid\IsSalaryUuidExists;
use Symfony\Component\Uid\Uuid;

final class UpdateEmployeeSalaryCommand implements AsyncCommandInterface
{
    public function __construct(
        #[IsSalaryUuidExists(code: 404)]
        public Uuid $id,
        public int $bonusSalary,
    ) {
    }
}
