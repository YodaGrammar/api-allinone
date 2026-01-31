<?php
declare(strict_types=1);
namespace App\Controller\User;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\UseCase\User\ReadUserUseCaseInterface;

final readonly class MeController{
    public function __construct(
        private ReadUserUseCaseInterface $useCase,
        private NormalizerInterface $normalizer
    ){}
    

    public function __invoke()
    {
        return New JsonResponse($this->normalizer->normalize($this->useCase->read()));
    }
}