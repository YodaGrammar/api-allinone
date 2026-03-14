<?php

declare(strict_types=1);

namespace App\Controller\Enum;

use App\Enum\ValidationCriteriaEnum;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReadValidationCriteriaController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(ValidationCriteriaEnum::values());
    }
}
