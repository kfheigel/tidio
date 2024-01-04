<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\Domain\Entity\Salary;
use Faker\Factory;
use Symfony\Component\Uid\Uuid;

final class SalaryBuilder
{
    private Uuid $id;
    private int $baseSalary;
    private ?int $bonusSalary;
    private ?int $salaryWithBonus;

    public function withId(Uuid $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function withBaseSalary(int $baseSalary): self
    {
        $this->baseSalary = $baseSalary;

        return $this;
    }

    public function withBonusSalary(?int $bonusSalary): self
    {
        $this->bonusSalary = $bonusSalary;

        return $this;
    }

    public function withSalaryWithBonus(?int $salaryWithBonus): self
    {
        $this->salaryWithBonus = $salaryWithBonus;

        return $this;
    }

    public static function any(): self
    {
        return new SalaryBuilder();
    }

    public function build(): Salary
    {
        $faker = Factory::create();
        $fakeBaseSalary = $faker->numberBetween(1000, 2000);
        $fakeBonusSalary = $faker->numberBetween(0, 100);
        $fakeSalaryWithBonus = $fakeBaseSalary + $fakeBonusSalary;

        return new Salary(
            $this->baseSalary ?? $fakeBaseSalary,
                $this->bonusSalary ?? $fakeBonusSalary,
                $this->salaryWithBonus ?? $fakeSalaryWithBonus,
                $this->id ?? Uuid::v4()
        );
    }
}
