<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Domain\Entity\Department;
use DateTimeInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;
use App\UseCase\CreateEmployee\CreateEmployeeCommand;
use App\UseCase\CreateSalary\CreateSalaryCommand;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class EmployeeController extends AbstractController
{
    #[Route('/employee', name: 'app_add_employee')]
    public function index(Request $request, MessageBusInterface $commandBus): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('departmentName', EntityType::class, [
                'class' => Department::class,
                'choice_label' => 'departmentName'
            ])
            ->add('baseSalary', NumberType::class, [
                'constraints' => [
                    new Assert\Range([
                        'min' => 0,
                        'minMessage' => 'The bonus factor must be above {{ min }}',
                        'invalidMessage' => 'The bonus factor must be a number',
                    ]),
                ],
            ])
            ->add('employmentDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->submit($request->request->all($form->getName()));

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var array $parameters */
                $parameters = $request->request->all()['form'];

                $name = $parameters['name'];
                $surname = $parameters['surname'];
                $departmentId = Uuid::fromString($parameters['departmentName']);
                $baseSalary = (int)$parameters['baseSalary'];
                $employmentDate = $parameters['employmentDate'];

                $salaryCommand = new CreateSalaryCommand(
                    $salaryId = Uuid::v4(),
                    $baseSalary
                );
                $commandBus->dispatch($salaryCommand);
                /** @var DateTimeInterface $employmentDay */
                $employmentDay = (new DateTimeImmutable())->createFromFormat('Y-m-d', $employmentDate);

                $employeeCommand = new CreateEmployeeCommand(
                    $name,
                    $surname,
                    $departmentId,
                    $salaryId,
                    $employmentDay
                );
                $commandBus->dispatch($employeeCommand);

                $this->addFlash('success', 'New Employee Created!');

                return $this->redirectToRoute('app_add_employee');
            }
        }

        return $this->render('employee/employee.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
