<?php

declare(strict_types=1);

namespace App\Controller\Challenge;

use Symfony\Component\HttpFoundation\Request;
use App\Exception\InvalidJsonVerboseException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\RequestDto\Challenge\CreateChallengeRequestDto;
use App\UseCase\Challenge\CreateChallengeUseCaseInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

readonly class CreateChallengeController {

    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private NormalizerInterface $normalizer,
        private CreateChallengeUseCaseInterface $useCase
    ){}

    public function __invoke(Request $request): JsonResponse {

        $challengeDto = $this->serializer->deserialize($request->getContent(), CreateChallengeRequestDto::class, 'json');
        
        $violations = $this->validator->validate($challengeDto);
        if ( $violations->count() > 0) {
            throw new InvalidJsonVerboseException($violations, CreateChallengeRequestDto::class);
        }

        return new JsonResponse(
            $this->normalizer->normalize($this->useCase->create($challengeDto)),
            Response::HTTP_CREATED
        );
    }
}
