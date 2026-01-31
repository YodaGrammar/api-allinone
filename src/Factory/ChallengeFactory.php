<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use App\Entity\Challenge;
use App\Enum\PeriodicityEnum;
use App\Enum\ChallengeUnitEnum;
use App\Enum\ValidationCriteriaEnum;
use App\RequestDto\Challenge\CreateChallengeRequestDto;

readonly class ChallengeFactory {

    public function create(CreateChallengeRequestDto $challengeDto, User $user): Challenge
    {
        return new Challenge(
            title: $challengeDto->title,
            description: $challengeDto->description,
            schedule: PeriodicityEnum::from($challengeDto->schedule),
            value: $challengeDto->value,
            unit: ChallengeUnitEnum::from($challengeDto->unit),
            validationCriteria: ValidationCriteriaEnum::from($challengeDto->validationCriteria),
            user: $user
        );
    }
}