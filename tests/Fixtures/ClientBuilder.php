<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use Faker\Factory;
use App\Domain\Entity\Client;
use Symfony\Component\Uid\Uuid;

final class ClientBuilder
{
    private Uuid $id;
    private string $email;

    public function withId(Uuid $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function withEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public static function any(): self
    {
        return new ClientBuilder();
    }

    public function build(): Client
    {
        $faker = Factory::create();

        return new Client(
            $this->email ?? $faker->email,
            $this->id ?? Uuid::v4()
        );
    }
}
