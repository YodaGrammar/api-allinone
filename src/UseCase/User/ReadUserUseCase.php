<?php

declare(strict_types=1);

namespace App\UseCase\User;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

readonly class ReadUserUseCase implements ReadUserUseCaseInterface
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function read(): User
    {
        $user = $this->security->getUser();
        if (false === $user instanceof User) {
            throw new \LogicException('User must be instance of User');
        }

        return $user;
    }
}
