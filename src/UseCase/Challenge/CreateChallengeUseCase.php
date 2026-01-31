<?php
declare(strict_types=1);
namespace App\UseCase\Challenge;

use App\Entity\Challenge;
use App\Factory\ChallengeFactory;
use App\Repository\ChallengeRepository;
use App\RequestDto\Challenge\CreateChallengeRequestDto;
use Symfony\Bundle\SecurityBundle\Security;

final class CreateChallengeUseCase implements CreateChallengeUseCaseInterface {

    public function __construct(
        private ChallengeFactory $challengeFactory,
        private ChallengeRepository $repository,
        private Security $security
    ){}

    public function create(CreateChallengeRequestDto $challengeDto): Challenge {

        $user = $this->security->getUser();
        $challenge = $this->challengeFactory->create($challengeDto, $user);

        $this->repository->persist($challenge)->flush();

        return $challenge;
    }
}


