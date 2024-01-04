<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Enum\BonusTypeEnum;
use App\Infrastructure\Repository\DepartmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::STRING, enumType: BonusTypeEnum::class)]
    private BonusTypeEnum $bonusType;

    #[ORM\Column(type: Types::INTEGER)]
    private int $bonusFactor;

    public function __construct(
        string $name,
        BonusTypeEnum $bonusType,
        int $bonusFactor,
        ?Uuid $id = null
    ) {
        $this->name = $name;
        $this->bonusType = $bonusType;
        $this->bonusFactor = $bonusFactor;
        $this->id = $id ?? Uuid::v4();
    }
    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBonusType(): BonusTypeEnum
    {
        return $this->bonusType;
    }

    public function setBonusType(BonusTypeEnum $bonusType): void
    {
        $this->bonusType = $bonusType;
    }

    public function getBonusFactor(): int
    {
        return $this->bonusFactor;
    }

    public function setBonusFactor(int $bonusFactor): void
    {
        $this->bonusFactor = $bonusFactor;
    }
}
