<?php

declare(strict_types=1);

namespace App\EventStorming;

use Symfony\Component\Uid\Uuid;

final class SalaryUpdatedEvent
{
    public function __construct(
        public Uuid $id
    ) {
    }
}
