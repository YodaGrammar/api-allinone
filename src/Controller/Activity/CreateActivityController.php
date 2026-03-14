<?php

declare(strict_types=1);

namespace App\Controller\Activity;

use App\Exception\InvalidJsonVerboseException;
use App\RequestDto\Activity\CreateActivityRequestDto;
use App\UseCase\Activity\CreateActivityUseCaseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateActivityController
{
    public function __construct(
        private SerializerInterface $serializer,
        private NormalizerInterface $normalizer,
        private ValidatorInterface $validator,
        private CreateActivityUseCaseInterface $useCase,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $activityDto = $this->serializer->deserialize($request->getContent(), CreateActivityRequestDto::class, 'json');

        $violations = $this->validator->validate($activityDto);

        if ($violations->count() > 0) {
            throw new InvalidJsonVerboseException($violations, CreateActivityRequestDto::class);
        }

        return new JsonResponse(
            $this->normalizer->normalize($this->useCase->create($activityDto), 'json'),
            Response::HTTP_CREATED
        );
    }
}
