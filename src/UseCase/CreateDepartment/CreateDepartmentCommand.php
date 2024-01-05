<?php

declare(strict_types=1);

namespace App\UseCase\CreateDepartment;

use App\Domain\Command\AsyncCommandInterface;
use App\Infrastructure\Validator\BonusType\IsOneOfBonusTypes;

final readonly class CreateDepartmentCommand implements AsyncCommandInterface
{
    public function __construct(
        public string $departmentName,
        #[IsOneOfBonusTypes(code: 404)]
        public string $bonusType,
        public int $bonusFactor,
    ) {
    }
}
