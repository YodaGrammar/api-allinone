<?php

declare(strict_types=1);

namespace App\Controller\Challenge;

use Symfony\Component\HttpFoundation\Request;
use App\Exception\InvalidJsonVerboseException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\RequestDto\Challenge\CreateChallengeRequestDto;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ReadListChallengeController {

    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ){}

    public function __invoke(Request $request): JsonResponse {

        dump(1);die;

        $challengeDto = $this->serializer->deserialize($request->getContent(), CreateChallengeRequestDto::class, 'json');

        $violations = $this->validator->validate($activityDto);

        if ( $violations->count() > 0) {
            throw new InvalidJsonVerboseException($violations, CreateChallengeRequestDto::class);
        }

        return new JsonResponse(
            $this->normalizer->normalize($activityDto),
            Response::HTTP_CREATED
        );
    }
}
