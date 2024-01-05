<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Domain\Entity\Enum\BonusTypeEnum;
use App\UseCase\CreateDepartment\CreateDepartmentCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class DepartmentController extends AbstractController
{
    #[Route('/department', name: 'app_add_department')]
    public function index(Request $request, MessageBusInterface $commandBus): Response
    {
        $form = $this->createFormBuilder()
            ->add('departmentName', TextType::class)
            ->add('bonusType', EnumType::class, [
                'expanded' => true,
                'class' => BonusTypeEnum::class
            ])
            ->add('bonusFactor', NumberType::class, [
                'constraints' => [
                    new Assert\Range([
                        'min' => 0,
                        'max' => 1000,
                        'minMessage' => 'The bonus factor must be between {{ min }} and {{ max }}',
                        'maxMessage' => 'The bonus factor must be between {{ min }} and {{ max }}',
                        'invalidMessage' => 'The bonus factor must be a number',
                    ]),
                ],
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                /** @var array $data */
                $data = $event->getData();
                $form = $event->getForm();
                if ('fixed' === $data['bonusType']) {
                    $form->add('bonusFactor', NumberType::class, [
                        'constraints' => [
                            new Assert\Range([
                                'min' => 0,
                                'max' => 1000,
                                'minMessage' => 'The bonus factor must be between {{ min }} and {{ max }}',
                                'maxMessage' => 'The bonus factor must be between {{ min }} and {{ max }}',
                                'invalidMessage' => 'The bonus factor must be a number',
                            ]),
                        ],
                    ]);
                } elseif ('percentage' === $data['bonusType']) {
                    $form->add('bonusFactor', NumberType::class, [
                        'constraints' => [
                            new Assert\Range([
                                'min' => 0,
                                'max' => 100,
                                'minMessage' => 'The bonus factor must be between {{ min }} and {{ max }}',
                                'maxMessage' => 'The bonus factor must be between {{ min }} and {{ max }}',
                                'invalidMessage' => 'The bonus factor must be a number',
                            ]),
                        ],
                    ]);
                }
            })
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->submit($request->request->all($form->getName()));

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var array $parameters */
                $parameters = $request->request->all()['form'];

                $departmentName = $parameters['departmentName'];
                $bonusType = $parameters['bonusType'];
                $bonusFactor = (int)$parameters['bonusFactor'];

                $command = new CreateDepartmentCommand(
                    $departmentName,
                    $bonusType,
                    $bonusFactor
                );
                $commandBus->dispatch($command);

                $this->addFlash('success', 'New Department Created!');

                return $this->redirectToRoute('app_add_department');
            }
        }

        return $this->render('department/department.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
