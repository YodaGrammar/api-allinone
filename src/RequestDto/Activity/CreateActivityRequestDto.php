<?php

namespace App\RequestDto\Activity;

use App\Enum\ChallengeUnitEnum;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateActivityRequestDto
{
    #[Assert\NotBlank,
        Assert\Type('string')]
    public mixed $title;

    #[Assert\NotBlank,
        Assert\Type('integer')]
    public mixed $value;

    #[Assert\Choice(callback: [ChallengeUnitEnum::class, 'values'])]
    public mixed $unit;

    #[Assert\Type('string')]
    public mixed $challengeId;

    public function __construct(
        mixed $title,
        mixed $value,
        mixed $unit,
        mixed $challengeId,
    ) {
        $this->title = $title;
        $this->value = $value;
        $this->unit = $unit;
        $this->challengeId = $challengeId;
    }
}
