<?php

declare(strict_types=1);

namespace App\Controller\Challenge;

use App\Exception\InvalidJsonVerboseException;
use App\RequestDto\Challenge\CreateChallengeRequestDto;
use App\UseCase\Challenge\CreateChallengeUseCaseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateChallengeController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private NormalizerInterface $normalizer,
        private CreateChallengeUseCaseInterface $useCase,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $challengeDto = $this->serializer->deserialize($request->getContent(), CreateChallengeRequestDto::class, 'json');

        $violations = $this->validator->validate($challengeDto);
        if ($violations->count() > 0) {
            throw new InvalidJsonVerboseException($violations, CreateChallengeRequestDto::class);
        }

        return new JsonResponse(
            $this->normalizer->normalize(
                data: $this->useCase->create($challengeDto),
                format: 'json',
                context: ['groups' => ['challenge:write', 'id', 'history:write']]
            ),
            Response::HTTP_CREATED
        );
    }
}
