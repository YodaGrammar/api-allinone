<?php

namespace App\Factory;

use App\Entity\Activity;
use App\Entity\Challenge;
use App\Entity\User;
use App\RequestDto\Activity\CreateActivityRequestDto;

class ActivityFactory
{
    public static function create(CreateActivityRequestDto $activityDto, User $user, ?Challenge $challenge = null): Activity
    {
        return new Activity(
            title: $activityDto->title,
            value: $activityDto->value,
            unit: $activityDto->unit,
            user: $user,
            challenge: $challenge
        );
    }
}
