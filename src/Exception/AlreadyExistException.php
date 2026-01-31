<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ExceptionMessageEnum;
class AlreadyExistException extends \Exception implements ExceptionInterface
{
    public function __construct(string $class = '', string $message = ExceptionMessageEnum::ALREADY_EXIST->value)
    {
        $array = explode('\\', $class);

        parent::__construct(end($array).' '.$message);
    }
}
