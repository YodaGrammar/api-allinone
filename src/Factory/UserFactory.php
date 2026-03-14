<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use App\RequestDto\Guest\CreateUserRequestDto;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserFactory
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function create(CreateUserRequestDto $userDto): User
    {
        $user = new User($userDto->email);

        return $user->setPassword($this->encoder->hashPassword($user, $userDto->password));
    }
}
