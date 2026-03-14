<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ExceptionMessageEnum;

class InvalidRouteParameterException extends \Exception implements ExceptionInterface
{
    public function __construct(string $class = '', string $message = ExceptionMessageEnum::INVALID_ROUTE_PARAMETER->value)
    {
        $array = explode('\\', $class);

        parent::__construct(end($array).' '.$message);
    }
}
