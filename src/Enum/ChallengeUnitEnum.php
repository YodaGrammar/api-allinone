<?php

declare(strict_types=1);

namespace App\Enum;

enum ChallengeUnitEnum: string
{
    use EnumTrait;

    case MINUTES = 'minutes';

    case STEPS = 'steps';

    case PAGES = 'pages';

    case LITERS = 'liters';

    case SESSIONS = 'sessions';
}

