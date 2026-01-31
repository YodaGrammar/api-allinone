<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\PeriodicityEnum;
use App\Enum\ChallengeUnitEnum;
use Symfony\Component\Uid\Ulid;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\ValidationCriteriaEnum;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;

#[
    ORM\Entity,
    ORM\Table(name: 'aio_challenge'),
]
class Challenge
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    private Ulid $id;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'text', nullable:true)]
    private ?string $description;

    #[ORM\Column(type: 'string', enumType: PeriodicityEnum::class)]
    private PeriodicityEnum $schedule;

    #[ORM\Column(type: 'integer')]
    private int $value;

    #[ORM\Column(type: 'string', enumType: ChallengeUnitEnum::class)]
    private ChallengeUnitEnum $unit;

    #[ORM\Column(type: 'string', enumType: ValidationCriteriaEnum::class)]
    private ValidationCriteriaEnum $validationCriteria;

    #[
        ORM\ManyToOne(targetEntity: User::class),
        ORM\JoinColumn(name: "fk_user_id", referencedColumnName: "id")
    ]
    private User $user;

    public function __construct(
        string $title,
        ?string $description = null,
        PeriodicityEnum $schedule,
        int $value,
        ChallengeUnitEnum $unit,
        ValidationCriteriaEnum $validationCriteria,
        User $user

    ){
        $this->title = $title;
        $this->description = $description;
        $this->schedule = $schedule;
        $this->value = $value;
        $this->unit = $unit;
        $this->validationCriteria = $validationCriteria;
        $this->user = $user;
    }
}