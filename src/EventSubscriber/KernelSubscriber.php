<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
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
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();

        if ('application/json' === $response->headers->get('content_type')) {
            /** @var Session $session */
            $session = $request->getSession();
            $sessionMessages = $session->getFlashbag()->all();

            $content = !empty($response->getContent()) ? json_decode($response->getContent(), true) : [];

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

            // Cleanup empty values and return parsed response.
            $data = array_filter($data);
            if (!empty($data)) {
                $response->setContent((string) json_encode($data));
            }
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
}
