<?php
declare(strict_types=1);

namespace App\UseCase\Todo;

use App\Entity\Todo\TodoList;
use App\RequestDto\Todo\CreateTodoListRequestDto;

interface CreateTodoListUseCaseInterface
{
    public function create(CreateTodoListRequestDto $todoList): TodoList;
}
