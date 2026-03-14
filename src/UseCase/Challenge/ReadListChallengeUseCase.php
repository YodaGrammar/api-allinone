<?php

declare(strict_types=1);

namespace App\UseCase\Challenge;

use App\Entity\User;
use App\Repository\ChallengeRepository;
use App\RequestDto\QueryParamRequestDto;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class ReadListChallengeUseCase implements ReadListChallengeUseCaseInterface
{
    public function __construct(
        private ChallengeRepository $repository,
        private Security $security,
    ) {
    }

    public function readList(QueryParamRequestDto $queryParam): array
    {
        $user = $this->security->getUser();

        if (false === $user instanceof User) {
            throw new \LogicException('User must be instance of User');
        }

        return $this->repository->findAllByFilter($queryParam, $user);
    }
}
