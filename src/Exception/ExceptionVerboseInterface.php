<?php

declare(strict_types=1);

namespace App\Exception;

/**
 * @property string   $source;
 * @property string[] $arrayMessage;
 */
interface ExceptionVerboseInterface extends ExceptionInterface
{
    public function getSource(): string;

    /**
     * @return string[]
     */
    public function getArrayMessage(): array;
}
