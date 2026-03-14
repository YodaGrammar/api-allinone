<?php

declare(strict_types=1);

namespace App\RequestDto\Challenge;

use App\Enum\ChallengeUnitEnum;
use App\Enum\PeriodicityEnum;
use App\Enum\ValidationCriteriaEnum;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateChallengeRequestDto
{
    #[Assert\NotBlank,
        Assert\Type('string')]
    public mixed $title;

    #[Assert\Type('string')]
    public mixed $description;

    #[Assert\Choice(callback: [PeriodicityEnum::class, 'values'])]
    public mixed $schedule;

    #[Assert\NotBlank,
        Assert\Type('integer')]
    public mixed $value;

    #[Assert\Choice(callback: [ChallengeUnitEnum::class, 'values'])]
    public mixed $unit;

    #[Assert\Choice(callback: [ValidationCriteriaEnum::class, 'values'])]
    public mixed $validationCriteria;

    public function __construct(
        mixed $title,
        mixed $schedule,
        mixed $value,
        mixed $unit,
        mixed $validationCriteria,
        mixed $description = null,
    ) {
        $this->title = $title;
        $this->schedule = $schedule;
        $this->value = $value;
        $this->unit = $unit;
        $this->validationCriteria = $validationCriteria;
        $this->description = $description;
    }
}
