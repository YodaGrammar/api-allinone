<?php

declare(strict_types=1);

namespace App\Controller\Challenge;

use App\Exception\InvalidRouteParameterException;
use App\UseCase\Challenge\ReadOneChallengeUseCaseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Uid\Ulid;

final readonly class ReadOneChallengeController
{
    public function __construct(
        private ReadOneChallengeUseCaseInterface $useCase,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(Request $request, string $challengeId): JsonResponse
    {
        if (false === Ulid::isValid($challengeId)) {
            throw new InvalidRouteParameterException(Ulid::class);
        }

        //        dump($this->useCase->readOne($challengeId)->getId()->toRfc4122());die;

        return new JsonResponse(
            $this->normalizer->normalize(
                $this->useCase->readOne(Ulid::fromString($challengeId)),
                'json',
                ['groups' => ['challenge:read']]
            )
        );
    }
}
