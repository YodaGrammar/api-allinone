<?php

declare(strict_types=1);

namespace App\Controller\Challenge;

use App\Exception\InvalidRouteParameterVerboseException;
use App\RequestDto\QueryParamRequestDto;
use App\UseCase\Challenge\ReadListChallengeUseCaseInterface;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ReadListChallengeController
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private ValidatorInterface $validator,
        private NormalizerInterface $normalizer,
        private ReadListChallengeUseCaseInterface $useCase,
    ) {
    }

    /**
     * @throws InvalidRouteParameterVerboseException
     * @throws ExceptionInterface
     */
    public function __invoke(Request $request): JsonResponse
    {
        $queryParam = $this->denormalizer->denormalize(
            HeaderUtils::parseQuery($request->getQueryString() ?? ''),
            QueryParamRequestDto::class,
            'json'
        );

        $violations = $this->validator->validate($queryParam);

        if ($violations->count() > 0) {
            throw new InvalidRouteParameterVerboseException($violations, QueryParamRequestDto::class);
        }

        return new JsonResponse(
            $this->normalizer->normalize(
                data: $this->useCase->readList($queryParam),
                format: 'json',
                context: ['groups' => ['challenge:read', 'id', 'history:read']]
            )
        );
    }
}
