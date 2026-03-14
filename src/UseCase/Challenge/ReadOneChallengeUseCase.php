<?php

declare(strict_types=1);

namespace App\UseCase\Challenge;

use App\Entity\Challenge;
use App\Entity\User;
use App\Repository\ChallengeRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\Ulid;

class ReadOneChallengeUseCase implements ReadOneChallengeUseCaseInterface
{
    public function __construct(
        private ChallengeRepository $repository,
        private Security $security,
    ) {
    }

    public function readOne(Ulid $challengeId): Challenge
    {
        $user = $this->security->getUser();

        if (false === $user instanceof User) {
            throw new \LogicException('User must be instance of User');
        }

        return $this->repository->findOneById($challengeId, $user);
    }
}
