<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\UseCase\User\ReadUserUseCaseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final readonly class MeController
{
    public function __construct(
        private ReadUserUseCaseInterface $useCase,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->normalizer->normalize($this->useCase->read()));
    }
}
