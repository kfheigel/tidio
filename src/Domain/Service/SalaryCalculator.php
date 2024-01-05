<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Department;
use App\Domain\Entity\Employee;
use App\Domain\Entity\Salary;
use App\Domain\Service\BonusTypeStrategy\BonusTypeStrategyInterface;
use App\UseCase\UpdateEmployeeSalary\UpdateEmployeeSalaryCommand;
use InvalidArgumentException;
use Symfony\Component\Messenger\MessageBusInterface;

final class SalaryCalculator implements CalculatorInterface
{
    private BonusTypeStrategyInterface $strategy;

    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }
    public function calculate(Employee $employee, Department $department, Salary $salary): Salary
    {
        $salary = $this->strategy->calculateBonusAmount($employee, $department, $salary);
        if (!is_int($salary->getBonusSalary())) {
            throw new InvalidArgumentException('Bonus salary was not calculated');
        }
        $command = new UpdateEmployeeSalaryCommand($salary->getId(), $salary->getBonusSalary());
        $this->messageBus->dispatch($command);

        return $salary;
    }

    public function setBonusTypeStrategy(string $strategy): void
    {
        $strategyClass = sprintf('App\Domain\Service\BonusTypeStrategy\%sBonusTypeStrategy', ucfirst($strategy));

        /** @var BonusTypeStrategyInterface $strategy */
        $strategy = new $strategyClass();

        $this->strategy = $strategy;
    }
}
