<?php

declare(strict_types=1);

namespace App\Controller\Activity;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateActivityController {

    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ){}

    public function __invoke(Request $request): JsonResponse {

        $activityDto = $this->serializer->deserialize($request->getContent(), CreateActivityRequestDto::class, 'json');

        $violations = $this->validator->validate($activityDto);

        if ( $violations->count() > 0) {
            throw new InvalidJsonVerboseException($violations, CreateActivityRequestDto::class);
        }

        return new JsonResponse(
            $this->normalizer->normalize($activityDto),
            Response::HTTP_CREATED
        );
    }
}
