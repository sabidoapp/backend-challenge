<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Subscriber for api requests.
 */
class ApiRequestSubscriber implements EventSubscriberInterface
{
    /**
     * Parser attributes from request to json format.
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        // default converter json to form data request.
        $data = [];
        if (0 === strpos($event->getRequest()->headers->get('Content-Type') ?? '', 'application/json')) {
            $data = json_decode($event->getRequest()->getContent(), true);
            $event->getRequest()->request->replace(is_array($data) ? $data : []);
            unset($data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                [
                    'onKernelRequest',
                    10,
                ],
            ],
        ];
    }
}
