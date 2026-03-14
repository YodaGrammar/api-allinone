<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\HistoryInterface;
use App\Entity\Trait\HistoryTrait;
use App\Entity\Trait\LogicDeleteInterface;
use App\Entity\Trait\LogicDeleteTrait;
use App\Enum\ChallengeUnitEnum;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Ulid;

class Activity implements LogicDeleteInterface, HistoryInterface
{
    use HistoryTrait;
    use LogicDeleteTrait;
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    public private(set) Ulid $id;

    #[ORM\Column(type: 'string')]
    #[Groups(['activity:write', 'activity:read'])]
    public private(set) string $title;

    #[ORM\Column(type: 'integer')]
    #[Groups(['activity:write', 'activity:read'])]
    public private(set) int $value;

    #[ORM\Column(type: 'string', enumType: ChallengeUnitEnum::class)]
    #[Groups(['activity:write', 'activity:read'])]
    public private(set) ChallengeUnitEnum $unit;

    #[ORM\ManyToOne(targetEntity: Challenge::class),
        ORM\JoinColumn(name: 'fk_challenge_id', referencedColumnName: 'id')]
    #[Groups(['activity:write', 'activity:read'])]
    public private(set) ?Challenge $challenge;

    #[ORM\ManyToOne(targetEntity: User::class),
        ORM\JoinColumn(name: 'fk_user_id', referencedColumnName: 'id')]
    public private(set) User $user;

    public function __construct(
        string $title,
        int $value,
        ChallengeUnitEnum $unit,
        User $user,
        ?Challenge $challenge = null,
    ) {
        $this->title = $title;
        $this->value = $value;
        $this->unit = $unit;
        $this->challenge = $challenge;
        $this->user = $user;
    }
}
