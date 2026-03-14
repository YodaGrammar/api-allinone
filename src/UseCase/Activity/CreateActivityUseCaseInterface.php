<?php

namespace App\UseCase\Activity;

use App\Entity\Activity;
use App\RequestDto\Activity\CreateActivityRequestDto;

interface CreateActivityUseCaseInterface
{
    public function create(CreateActivityRequestDto $activityDto): Activity;
}
