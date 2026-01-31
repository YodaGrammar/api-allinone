<?php 
declare(strict_types=1);
namespace App\EventListener;

use App\Enum\ExceptionMessageEnum;
use App\Exception\AlreadyExistException;
use App\Exception\ExceptionInterface;
use App\Exception\ExceptionVerboseInterface;
use App\Exception\NotFoundException;
use App\Exception\NotMatchException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ExceptionInterface) {
            $event->setResponse(new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST));
        }

        if ($exception instanceof ExceptionVerboseInterface) {
            $event->setResponse(new JsonResponse(
                ['errors' => [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'source' => $exception->getSource(),
                    'title' => $exception->getMessage(),
                    'detail' => $exception->getArrayMessage(),
                ],
                ],
                Response::HTTP_BAD_REQUEST)
            );
        }

        if ($exception instanceof AlreadyExistException) {
            $event->setResponse(new Response($exception->getMessage(), Response::HTTP_CONFLICT));
        }
        if ($exception instanceof NotFoundException) {
            $event->setResponse(new Response($exception->getMessage(), Response::HTTP_NOT_FOUND));
        }
        if ($exception instanceof NotMatchException) {
            $event->setResponse(new Response($exception->getMessage(), Response::HTTP_CONFLICT));
        }
        if ($exception instanceof NotNormalizableValueException) {
            $event->setResponse(new Response(ExceptionMessageEnum::INVALID_JSON->value, Response::HTTP_BAD_REQUEST));
        }
        if ($exception instanceof NotEncodableValueException) {
            $event->setResponse(new Response(ExceptionMessageEnum::INVALID_JSON->value, Response::HTTP_BAD_REQUEST));
        }
    }
}