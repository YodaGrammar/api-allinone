<?php

namespace App\UseCase\Challenge;

use App\Entity\Challenge;
use Symfony\Component\Uid\Ulid;

interface ReadOneChallengeUseCaseInterface
{
    public function readOne(Ulid $challengeId): Challenge;
}
