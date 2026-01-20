<?php

declare(strict_types=1);

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateChallengeRequestDto {

    #[
        Assert\NotBlank,
        Assert\Type('string')
    ]
    private mixed $title;

    #[Assert\Type('text')]
    private mixed $description;

    #[Assert\Choice(callback: [PeriodicityEnum::class, 'values'])]
    private mixed $schedule;

    #[
        Assert\NotBlank
        Assert\Type('integer'),
    ]
    private mixed $value;

    #[Assert\Choice(callback: [ChallengeUnitEnum::class, 'values'])]
    private mixed $unit;

    #[Assert\Choice(callback: [ConstraintValidationEnum::class, 'values'])]
    private mixed $direction;
}
