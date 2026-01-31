<?php
declare(strict_types=1);
namespace App\Exception;

/**
 * @property string $source;
 * @property array  $arrayMessage;
 */
interface ExceptionVerboseInterface extends ExceptionInterface
{
    public function getSource(): string;

    /**
     * @return mixed[]
     */
    public function getArrayMessage(): array;
}