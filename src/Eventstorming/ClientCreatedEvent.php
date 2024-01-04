<?php

declare(strict_types=1);

namespace App\Eventstorming;



final class ClientCreatedEvent
{
    public function __construct(public string $id, public string $email)
    {
    }
}
