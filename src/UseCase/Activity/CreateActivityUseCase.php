<?php

namespace App\UseCase\Activity;

use App\Entity\Activity;
use App\Entity\User;
use App\Factory\ActivityFactory;
use App\Repository\ActivityRepository;
use App\RequestDto\Activity\CreateActivityRequestDto;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class CreateActivityUseCase implements CreateActivityUseCaseInterface
{
    public function __construct(
        private ActivityFactory $activityFactory,
        private ActivityRepository $repository,
        private Security $security,
    ) {
    }

    public function create(CreateActivityRequestDto $activityDto): Activity
    {
        $user = $this->security->getUser();
        if (false === $user instanceof User) {
            throw new \LogicException('User must be instance of User');
        }
        $challenge = $this->activityFactory->create($activityDto, $user);

        $this->repository->persist($challenge)->flush();

        return $challenge;
    }
}
