<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Client;
use Symfony\Component\Uid\Uuid;

interface ClientRepositoryInterface
{
    public function save(Client $client): void;
    public function get(Uuid $uuid): Client;
    public function findOne(Uuid $uuid): ?Client;
    public function findAll(): array;
}
