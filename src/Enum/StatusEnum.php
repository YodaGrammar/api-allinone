<?php

namespace App\Enum;

enum StatusEnum:string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    public static function statusTodo():array {
        return [
            self::TODO->value,
            self::IN_PROGRESS->value,
            self::DONE->value,
        ];
    }
}
