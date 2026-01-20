<?php

declare(strict_types=1);

namespace App\Enum;

enum ValidtionCriteriaEnum: string
{
    use EnumTrait;

    case at_least = 'at_least';

    case at_most = 'at_most';

    case exact = 'exact';
}

