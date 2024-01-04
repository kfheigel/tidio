<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Infrastructure\Repository\SalaryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SalaryRepository::class)]
class Salary
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[ORM\Column(type: Types::INTEGER)]
    private int $baseSalary;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $bonusSalary;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $salaryWithBonus;

    public function __construct(
        int $baseSalary,
        ?int $bonusSalary,
        ?int $salaryWithBonus,
        ?Uuid $id = null
    ) {
        $this->baseSalary = $baseSalary;
        $this->bonusSalary = $bonusSalary;
        $this->salaryWithBonus = $salaryWithBonus;
        $this->id = $id ?? Uuid::v4();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getBaseSalary(): int
    {
        return $this->baseSalary;
    }

    public function setBaseSalary(int $baseSalary): void
    {
        $this->baseSalary = $baseSalary;
    }

    public function getBonusSalary(): ?int
    {
        return $this->bonusSalary;
    }

    public function setBonusSalary(int $bonusSalary): void
    {
        $this->bonusSalary = $bonusSalary;
    }

    public function getSalaryWithBonus(): ?int
    {
        return $this->salaryWithBonus;
    }

    public function setSalaryWithBonus(int $salaryWithBonus): void
    {
        $this->salaryWithBonus = $salaryWithBonus;
    }
}
