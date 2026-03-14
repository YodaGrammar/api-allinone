<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ExceptionMessageEnum;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidRouteParameterVerboseException extends AbstractVerboseException implements ExceptionVerboseInterface
{
    public function __construct(ConstraintViolationListInterface $violations, string $source)
    {
        $array = [];
        foreach ($violations as $violation) {
            $array[$violation->getPropertyPath()] = $violation->getMessage();
        }

        parent::__construct($source, $array, ExceptionMessageEnum::INVALID_ROUTE_PARAMETER->value);
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
