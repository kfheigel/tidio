<?php

namespace App\UI\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\UseCase\CreateClient\CreateClientCommand;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(MessageBusInterface $commandBus): Response
    {
        $email = 'test@email.com';
        $message = new CreateClientCommand($email);
        $commandBus->dispatch($message);

        return new Response('command send');
    }
}
