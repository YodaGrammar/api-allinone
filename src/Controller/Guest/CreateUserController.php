<?php
declare(strict_types=1);
namespace App\Controller\Guest;

use Symfony\Component\HttpFoundation\Request;
use App\Exception\InvalidJsonVerboseException;
use App\RequestDto\Guest\CreateUserRequestDto;
use Symfony\Component\HttpFoundation\Response;
use App\UseCase\User\CreateUserUseCaseInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class CreateUserController{

    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private CreateUserUseCaseInterface $useCase

    ) {}

    public function __invoke(Request $requuest)
    {
        $userDto = $this->serializer->deserialize($requuest->getContent(), CreateUserRequestDto::class, 'json');

        $violations = $this->validator->validate($userDto);
        if (0 < $violations->count()) {
            throw new InvalidJsonVerboseException($violations, CreateUserRequestDto::class);
        }
        $this->useCase->create($userDto);

        return new Response(status: Response::HTTP_CREATED);
    }
}