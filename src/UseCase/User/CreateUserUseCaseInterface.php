<?php
declare(strict_types=1);
namespace App\UseCase\User;

use App\RequestDto\Guest\CreateUserRequestDto;

interface CreateUserUseCaseInterface {
    public function create(CreateUserRequestDto $userDto);
}