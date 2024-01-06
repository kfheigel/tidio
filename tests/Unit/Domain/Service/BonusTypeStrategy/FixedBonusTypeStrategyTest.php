<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Service\BonusTypeStrategy;

use App\Domain\Entity\Enum\BonusTypeEnum;
use App\Domain\Service\BonusTypeStrategy\FixedBonusTypeStrategy;
use App\Tests\Common\UnitTestCase;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\Assert;

final class FixedBonusTypeStrategyTest extends UnitTestCase
{
    private FixedBonusTypeStrategy $bonusTypeStrategy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bonusTypeStrategy = new FixedBonusTypeStrategy();
    }

    /**
     * @test
     * @dataProvider provideValues
     */
    public function calculate_bonus_amount_based_on_department_with_fixed_bonus_type(int $givenBonusFactor, DateTimeInterface $givenEmploymentDate, int $expectedBonusSalary): void
    {
        //given
        $givenBaseSalary = 1000;
        $givenSalary = $this->giveSalary($givenBaseSalary);

        $givenBonusType = BonusTypeEnum::fixed;
        $givenDepartment = $this->giveDepartment($givenBonusType, $givenBonusFactor);

        $givenEmployee = $this->giveEmployee($givenDepartment->getId(), $givenSalary->getId(), $givenEmploymentDate);

        //when
        $salary = $this->bonusTypeStrategy->calculateBonusAmount($givenEmployee, $givenDepartment, $givenSalary);

        //then
        Assert::assertEquals($expectedBonusSalary, $salary->getBonusSalary());
    }

    public function provideValues(): array
    {
        return [
            [100, new DateTimeImmutable('2024-01-01'), 0],
            [100, new DateTimeImmutable('2023-01-01'), 100],
            [10, new DateTimeImmutable('2020-01-01'), 40],
            [100, new DateTimeImmutable('2014-01-01'), 1000],
            [100, new DateTimeImmutable('2013-01-01'), 1000],
            [100, new DateTimeImmutable('2020-09-30'), 300],
        ];
    }
}