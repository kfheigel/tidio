<?php

declare(strict_types=1);

namespace App\UseCase\CreateClient;

use App\Domain\Entity\Client;
use App\Eventstorming\ClientCreatedEvent;
use App\Domain\Messenger\CommandHandlerInterface;
use App\Domain\Repository\ClientRepositoryInterface;
use App\UseCase\CreateClient\CreateClientCommand;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateClientHandler implements CommandHandlerInterface
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private MessageBusInterface $eventBus
        )
    {
    }

    public function __invoke(CreateClientCommand $command)
    {
        $client = new Client($command->getEmail());
        $this->clientRepository->save($client);
        
        $event = new ClientCreatedEvent($client->getId()->toRfc4122(), $client->getEmail());

        $this->eventBus->dispatch($event);
    }
}
