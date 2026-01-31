<?php
declare(strict_types=1);
namespace App\UseCase\Challenge;

use App\Entity\Challenge;
use App\RequestDto\Challenge\CreateChallengeRequestDto;

interface CreateChallengeUseCaseInterface {
    public function create(CreateChallengeRequestDto $userDto): Challenge;
}