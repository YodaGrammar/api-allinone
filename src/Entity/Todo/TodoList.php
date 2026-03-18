<?php
declare(strict_types=1);

namespace App\Entity\Todo;

use App\Entity\TodoItem;
use App\Entity\Trait\HistoryInterface;
use App\Entity\Trait\HistoryTrait;
use App\Entity\Trait\LogicDeleteInterface;
use App\Entity\Trait\LogicDeleteTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity]
class TodoList implements LogicDeleteInterface,HistoryInterface
{
    use HistoryTrait;
    use LogicDeleteTrait;

    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    public private(set) Ulid $id;

    #[ORM\Column(length: 200)]
    public private(set) string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    public private(set) ?string $description = null;

    #[ORM\Column(length: 20)]
    public private(set) string $color = '#6366f1';   // couleur de la liste

    #[ORM\OneToMany(
        mappedBy: 'todoList',
        targetEntity: TodoItem::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $items;

    public function __construct()
    {
        $this->items     = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }



    // ── Computed helpers ──────────────────────────

    public function getCompletionRate(): float
    {
        $total = $this->items->count();
        if ($total === 0) return 0.0;

        $done = $this->items->filter(
            fn(TodoItem $i) => $i->getStatus() === TodoItem::STATUS_DONE
        )->count();

        return round(($done / $total) * 100, 1);
    }

    public function getPendingCount(): int
    {
        return $this->items->filter(
            fn(TodoItem $i) => $i->getStatus() === TodoItem::STATUS_TODO
        )->count();
    }

    public function addItem(TodoItem $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setTodoList($this);
        }
        return $this;
    }

    public function removeItem(TodoItem $item): static
    {
        $this->items->removeElement($item);
        return $this;
    }
}
