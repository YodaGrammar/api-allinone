<?php
declare(strict_types=1);

namespace App\UseCase\Todo;

use App\Entity\Challenge;
use App\Entity\Todo\TodoList;
use App\Entity\User;
use App\RequestDto\Todo\CreateTodoListRequestDto;

class CreateTodoListUseCase implements CreateTodoListUseCaseInterface
{
        public function __construct(
            private readonly CreateChallengeUseCaseInterface $challengeFactory,
            private readonly TodoListRepositoryInterface $repository,
            private readonly SecurityInterface $security,
        ) {
        }

    public function create(CreateTodoListRequestDto $todoList): TodoList
    {
        $user = $this->security->getUser();
        if (false === $user instanceof User) {
            throw new \LogicException('User must be instance of User');
        }
        $challenge = $this->challengeFactory->create($challengeDto, $user);

        $this->repository->persist($challenge)->flush();

        return $challenge;
    }
}
