<?php

declare(strict_types=1);

namespace App\Tests\Common;

use App\Domain\Repository\DepartmentRepositoryInterface;
use App\Tests\Doubles\Repository\DepartmentInMemoryRepository;
use App\Tests\Fixtures\DepartmentBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

abstract class ValidatorTestCase extends ConstraintValidatorTestCase
{
    protected ContainerInterface $container;
    protected DepartmentRepositoryInterface $departmentRepository;

    protected string $defaultViolationCode = '400';

    protected function setUp(): void
    {
        $kernelTestCase = new class extends KernelTestCase{
            public static function getContainer(): ContainerInterface {
                return parent::getContainer();
            }
            public static function bootKernel(array $options = []): KernelInterface {
                return parent::bootKernel();
            }
        };

        $kernelTestCase::bootKernel();
        $this->container = $kernelTestCase::getContainer();
        $this->container->set(DepartmentRepositoryInterface::class, new DepartmentInMemoryRepository());

        parent::setUp();
    }

    protected function giveDepartment(string $name): void
    {
        $department = DepartmentBuilder::any()
            ->withName($name)
            ->build();

        $this->departmentRepository->save($department);
    }
}
