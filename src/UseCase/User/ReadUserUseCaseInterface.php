<?php
declare(strict_types=1);
namespace App\UseCase\User;

use App\Entity\User;

interface ReadUserUseCaseInterface {
    public function read(): User;
}