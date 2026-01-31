<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ExceptionMessageEnum;

class NotMatchException extends \Exception implements ExceptionInterface
{
    public function __construct(string $class = '', string $message = ExceptionMessageEnum::NOT_MATCH->value)
    {
        $array = explode('\\', $class);

        parent::__construct(end($array).' '.$message);
    }
}
