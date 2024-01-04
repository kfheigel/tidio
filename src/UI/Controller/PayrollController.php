<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Domain\Messenger\MessageBus\QueryBus;
use App\ReadModel\EmployeeSalary\EmployeeSalaryQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class PayrollController extends AbstractController
{
    #[Route('/payroll', name: 'app_payroll', methods: ['GET'])]
    public function showPayroll(QueryBus $queryBus): JsonResponse
    {

        $query = new EmployeeSalaryQuery();
        $result = $queryBus->find($query);

        return new JsonResponse($result);
    }
}
