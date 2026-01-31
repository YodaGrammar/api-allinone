<?php
declare(strict_types=1);
namespace App\UseCase\User;

use App\Factory\UserFactory;
use App\Repository\UserRepository;
use App\RequestDto\Guest\CreateUserRequestDto;

readonly class CreateUserUseCase implements CreateUserUseCaseInterface
{
    public function __construct(
        private UserFactory $userFactory,
        private UserRepository $repository
    ){}

    public function create(CreateUserRequestDto $userDto): void {
        $user = $this->userFactory->create($userDto);

        $this->repository->persist($user)->flush();
    }
}