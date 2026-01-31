<?php

declare(strict_types=1);

namespace App\Exception;

abstract class AbstractVerboseException extends \Exception implements ExceptionVerboseInterface
{
    /**
     * @param mixed[] $arrayMessage
     */
    public function __construct(
        protected readonly string $source,
        protected readonly array $arrayMessage,
        string $message,
    ) {
        parent::__construct($message);
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getArrayMessage(): array
    {
        return $this->arrayMessage;
    }
}