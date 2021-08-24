<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Subscriber for responses.
 */
class KernelSubscriber implements EventSubscriberInterface
{
    /**
     * Rebuild reponse with session messages. Include original response from controllers.
     */
    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();

        if ('application/json' === $response->headers->get('content_type')) {
            $data = $this->parserMessages($request, $response);

            $response->setContent((string) json_encode($data));
            $event->setResponse($response);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => [
                [
                    'onKernelResponse',
                    10,
                ],
            ],
        ];
    }

    /**
     * Parse session messages on API response.
     */
    private function parserMessages(Request $request, Response $response): array
    {
        /** @var Session $session */
        $session = $request->getSession();
        $sessionMessages = $session->getFlashBag()->all();

        $content = is_string($response->getContent()) ? json_decode($response->getContent(), true) : [];

        // Concat messages when already exists.
        $messages = (isset($content['messages']))
            ? array_merge($content['messages'], $sessionMessages)
            : $sessionMessages;

        $data = [
            'data' => $content,
            'messages' => $messages,
        ];

        if (isset($content['data'])) {
            $data = $content;
            $data['messages'] = $messages;
        }

        unset($content, $sessionMessages, $messages);

        if (isset($data['data']['messages'])) {
            unset($data['data']['messages']);
        }

        return array_filter($data);
    }
}
