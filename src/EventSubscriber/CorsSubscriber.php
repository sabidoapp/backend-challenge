<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Subscriber for responses.
 */
class CorsSubscriber implements EventSubscriberInterface
{
    private ?string $allowedMethod = null;

    public function onKernelException(ExceptionEvent $event): void
    {
        $realMethod = $event->getRequest()->getRealMethod();

        if (in_array($realMethod, [Request::METHOD_OPTIONS, Request::METHOD_HEAD], true)) {
            $response = new JsonResponse();
            $response->setStatusCode(JsonResponse::HTTP_ACCEPTED);

            /** @var MethodNotAllowedHttpException $exception */
            $exception = $event->getThrowable();
            if (method_exists($exception, 'getHeaders')) {
                $headers = $exception->getHeaders();
                $this->allowedMethod = isset($headers['Allow']) ? $headers['Allow'] : null;
            }

            $event->setResponse($response);
        }
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $response = $event->getResponse();
        $realMethod = $event->getRequest()->getRealMethod();

        if (in_array($realMethod, [Request::METHOD_OPTIONS, Request::METHOD_HEAD], true)) {
            $response = new JsonResponse();
            $realMethod = null;
        }

        $this->rebuildHeaders($response, $this->allowedMethod);

        $event->setResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', 9999],
            KernelEvents::EXCEPTION => ['onKernelException', 9999],
        ];
    }

    private function rebuildHeaders(Response &$response, ?string $realMethod = null): void
    {
        $allowMethods = [
            Request::METHOD_OPTIONS,
            Request::METHOD_HEAD,
        ];

        $allowMethods[] = $realMethod;

        if (empty($realMethod)) {
            $allowMethods = array_merge(
                $allowMethods,
                [
                    Request::METHOD_GET,
                    Request::METHOD_POST,
                    Request::METHOD_PUT,
                    Request::METHOD_PATCH,
                    Request::METHOD_DELETE,
                ]
            );
        }

        $allowMethods = array_unique(
            array_filter($allowMethods)
        );

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', implode(', ', $allowMethods));
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept');
    }
}
