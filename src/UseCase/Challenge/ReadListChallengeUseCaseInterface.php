<?php

declare(strict_types=1);

namespace App\UseCase\Challenge;

use App\Entity\Challenge;
use App\RequestDto\QueryParamRequestDto;

interface ReadListChallengeUseCaseInterface
{
    /**
     * @return Challenge[]
     */
    public function readList(QueryParamRequestDto $queryParam): array;
}
