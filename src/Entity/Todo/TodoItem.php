<?php
declare(strict_types=1);

namespace App\Entity\Todo;

use App\Entity\Trait\HistoryInterface;
use App\Entity\Trait\HistoryTrait;
use App\Entity\Trait\LogicDeleteInterface;
use App\Entity\Trait\LogicDeleteTrait;
use App\Enum\PriorityEnum;
use App\Enum\StatusEnum;
use App\Repository\TodoItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity]
class TodoItem implements HistoryInterface, LogicDeleteInterface
{
    use HistoryTrait;
    use LogicDeleteTrait;

    #[ORM\Id,
        ORM\Column(type: UlidType::NAME, unique: true),
        ORM\GeneratedValue(strategy: 'CUSTOM'),
        ORM\CustomIdGenerator(class: UlidGenerator::class)]
    #[Groups(['challenge:write', 'challenge:read', 'id'])]
    public private(set) Ulid $id;

    #[ORM\Column(length: 500)]
    public private(set) string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    public private(set) ?string $note = null;

    #[ORM\Column(type: 'string', enumType: StatusEnum::class)]
    public private(set) StatusEnum $status = StatusEnum::TODO;

    #[ORM\Column(type: 'string', enumType: PriorityEnum::class)]
    public private(set) int $priority;

    #[ORM\Column(type: 'integer')]
    public private(set) int $position = 0;

    #[ORM\Column(type: 'date', nullable: true)]
    public private(set) ?\DateTimeInterface $dueDate = null;

    #[ORM\Column(nullable: true)]
    public private(set) ?\DateTimeImmutable $completedAt = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    public private(set) TodoList $todoList;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function isOverdue(): bool
    {
        return $this->dueDate !== null
            && $this->status !== self::STATUS_DONE
            && $this->dueDate < new \DateTime('today');
    }

    public function isDone(): bool
    {
        return $this->status === self::STATUS_DONE;
    }

    public function complete(): static
    {
        $this->status = self::STATUS_DONE;
        $this->completedAt = new \DateTimeImmutable();
        return $this;
    }

    public function reopen(): static
    {
        $this->status = self::STATUS_TODO;
        $this->completedAt = null;
        return $this;
    }

    // ── Getters / Setters ─────────────────────────

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $t): static
    {
        $this->title = $t;
        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $n): static
    {
        $this->note = $n;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $s): static
    {
        if ($s === self::STATUS_DONE && $this->completedAt === null) {
            $this->completedAt = new \DateTimeImmutable();
        }
        if ($s !== self::STATUS_DONE) {
            $this->completedAt = null;
        }
        $this->status = $s;
        return $this;
    }
}
