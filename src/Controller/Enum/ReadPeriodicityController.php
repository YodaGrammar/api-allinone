<?php

declare(strict_types=1);

namespace App\Controller\Enum;

use App\Enum\PeriodicityEnum;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReadPeriodicityController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(PeriodicityEnum::values());
    }
}
