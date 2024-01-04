<?php

namespace App\UI\Controller;

use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\UseCase\CreateEmployee\CreateEmployeeCommand;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Uid\Uuid;

final class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(MessageBusInterface $commandBus): Response
    {
        $name = 'Jessica';
        $surname = 'Rabbit';
        $departmentId = Uuid::v4();
        $salaryId = Uuid::v4();
        $employmentDate = new DateTimeImmutable('now');

        $message = new CreateEmployeeCommand(
            $name,
            $surname,
            $departmentId,
            $salaryId,
            $employmentDate
        );
        $commandBus->dispatch($message);

        return new Response('command send');
    }
}
