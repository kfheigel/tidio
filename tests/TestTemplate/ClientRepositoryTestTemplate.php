<?php

declare(strict_types=1);

namespace App\Tests\TestTemplate;

use App\Domain\Entity\Client;
use Symfony\Component\Uid\Uuid;
use App\Tests\Fixtures\ClientBuilder;
use App\Domain\Repository\ClientRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class ClientRepositoryTestTemplate extends KernelTestCase
{
    abstract protected function repository(): ClientRepositoryInterface;
    abstract protected function save(Client $client): void;

    /** @test */
    public function add_and_find_by_id(): void
    {
        // given
        $givenId = '809e6b49-49de-45e2-8592-53fc0b957602';
        $givenClient = ClientBuilder::any()
            ->withId(Uuid::fromString($givenId))
            ->withEmail('test@test.com')
            ->build();

        // when
        $this->save($givenClient);
        $client = $this->repository()->findOne($givenClient->getId());
        $this->assertNotNull($client);

        // then
        self::assertEquals($givenClient, $client);
    }
}
