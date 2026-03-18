<?php

declare(strict_types=1);

namespace App\Entity\Trait;

interface HistoryInterface
{
    public function onPreUpdate(): void;
    public function onPrePersist(): void;
}
