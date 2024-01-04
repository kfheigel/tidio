<?php

declare(strict_types=1);

namespace App\UseCase\CreateClient;


final class CreateClientCommand
{
    public function __construct(private string $email)
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
