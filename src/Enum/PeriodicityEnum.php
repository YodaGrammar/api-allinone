<?php

declare(strict_types=1);

namespace App\Enum;

enum PeriodicityEnum: string
{
    use EnumTrait;

    case DAILY = 'daily';

    case WEEKLY = 'weekly';

    case MONTHLY = 'monthly';

    case YEARLY = 'yearly';
}

