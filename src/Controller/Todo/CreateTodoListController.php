<?php
declare(strict_types=1);

namespace App\Controller\Todo;

use App\UseCase\Challenge\CreateChallengeUseCaseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateTodoListController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private NormalizerInterface $normalizer,
        private CreateTodoListUseCaseInterface $useCase,
    ) {
    }
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(
            data: ['message' => 'Create Todo List'],
            status: Response::HTTP_CREATED
        );
    }
}
