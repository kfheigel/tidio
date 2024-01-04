<?php

declare(strict_types=1);

namespace App\UI\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Infrastructure\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HealthcheckController extends AbstractController
{
    public function __construct(
        private readonly EmployeeRepository $employeeRepository
    ) {
    }

    #[Route('/healthcheck', name: 'app_healthcheck')]
    public function index(): JsonResponse
    {
        $status = Response::HTTP_OK;
        $checks = [
            'database' => 'ok'
        ];

        try {
            $this->employeeRepository->findAll();
        } catch (Exception) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $checks['database'] = 'not ok';
        }

        return new JsonResponse($checks, $status);
    }
}
