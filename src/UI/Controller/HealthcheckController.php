<?php

declare(strict_types=1);

namespace App\UI\Controller;

use Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Infrastructure\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HealthcheckController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ClientRepository $clientRepository
        )
    {
    }

    #[Route('/healthcheck', name: 'app_healthcheck')]
    public function index(): JsonResponse
    {
        $status = Response::HTTP_OK;
        $checks = [
            'database' => 'ok'
        ];

        try {
            $this->clientRepository->findAll();
        } catch (Exception $exception) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $checks['database'] = 'not ok';
        }

        return new JsonResponse($checks, $status);
    }
}
