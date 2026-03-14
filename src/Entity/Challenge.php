<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\HistoryInterface;
use App\Entity\Trait\HistoryTrait;
use App\Entity\Trait\LogicDeleteInterface;
use App\Entity\Trait\LogicDeleteTrait;
use App\Enum\ChallengeUnitEnum;
use App\Enum\PeriodicityEnum;
use App\Enum\ValidationCriteriaEnum;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity,
    ORM\Table(name: 'aio_challenge'),]
class Challenge implements LogicDeleteInterface, HistoryInterface
{
    use HistoryTrait;
    use LogicDeleteTrait;

    #[ORM\Id,
        ORM\Column(type: UlidType::NAME, unique: true),
        ORM\GeneratedValue(strategy: 'CUSTOM'),
        ORM\CustomIdGenerator(class: UlidGenerator::class)]
    #[Groups(['challenge:write', 'challenge:read', 'id'])]
    public private(set) Ulid $id;

    #[ORM\Column(type: 'string')]
    #[Groups(['challenge:write', 'challenge:read'])]
    public private(set) string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['challenge:write', 'challenge:read'])]
    public private(set) ?string $description;

    #[ORM\Column(type: 'string', enumType: PeriodicityEnum::class)]
    #[Groups(['challenge:write', 'challenge:read'])]
    public private(set) PeriodicityEnum $schedule;

    #[ORM\Column(type: 'integer')]
    #[Groups(['challenge:write', 'challenge:read'])]
    public private(set) int $value;

    #[ORM\Column(type: 'string', enumType: ChallengeUnitEnum::class)]
    #[Groups(['challenge:write', 'challenge:read'])]
    public private(set) ChallengeUnitEnum $unit;

    #[ORM\Column(type: 'string', enumType: ValidationCriteriaEnum::class)]
    #[Groups(['challenge:write', 'challenge:read'])]
    public private(set) ValidationCriteriaEnum $validationCriteria;

    #[ORM\ManyToOne(targetEntity: User::class),
        ORM\JoinColumn(name: 'fk_user_id', referencedColumnName: 'id')]
    public private(set) User $user;

    public function __construct(
        string $title,
        PeriodicityEnum $schedule,
        int $value,
        ChallengeUnitEnum $unit,
        ValidationCriteriaEnum $validationCriteria,
        User $user,
        ?string $description = null,
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->schedule = $schedule;
        $this->value = $value;
        $this->unit = $unit;
        $this->validationCriteria = $validationCriteria;
        $this->user = $user;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }
}
