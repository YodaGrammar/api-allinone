<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ExceptionMessageEnum;

class NotFoundException extends \Exception implements ExceptionInterface
{
    public function __construct(string $class = '', string $message = ExceptionMessageEnum::NOT_FOUND->value)
    {
        $array = explode('\\', $class);

        parent::__construct(end($array).' '.$message);
    }
}
