<?php

declare(strict_types=1);

namespace App\Entity\Trait;

interface LogicDeleteInterface
{
    public function isDeleted(): ?bool;

    public function setDeleted(bool $deleted): self;
}
