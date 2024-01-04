<?php

declare(strict_types=1);

namespace App\UseCase\CreateEmployee;

use DateTimeInterface;
use Symfony\Component\Uid\Uuid;

final readonly class CreateEmployeeCommand
{
    public function __construct(
        public string $name,
        public string $surname,
        public Uuid $departmentId,
        public Uuid $salaryId,
        public DateTimeInterface $employmentDate
    ) {
    }
}
