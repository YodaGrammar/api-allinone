<?php
declare(strict_types=1);
namespace App\Controller\Enum;

use App\Enum\ChallengeUnitEnum;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReadChallengeUnitController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(ChallengeUnitEnum::values());
    }
}