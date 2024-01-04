<?php

declare(strict_types=1);

namespace App\Domain\Entity\Enum;

enum BonusTypeEnum: string
{
    case percentage = 'percentage';
    case fixed = 'fixed';
}
