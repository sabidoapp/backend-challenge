<?php

declare(strict_types=1);

namespace App\Controller;

use App\CustomSerializer;
use Closure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class BaseController extends AbstractController
{
    public CustomSerializer $serializer;

    public TranslatorInterface $translator;

    public function __construct(CustomSerializer $serializer, TranslatorInterface $translator)
    {
        $this->serializer = $serializer;
        $this->translator = $translator;
    }

    /**
     * Generate message translated by domain.
     */
    protected function trans(string $message, array $params, string $domain): string
    {
        return $this->translator->trans($message, $params, $domain);
    }

    /**
     * Generate JSON response with serializer groups.
     */
    protected function response(array $data, array $groups = [], int $statusCode = JsonResponse::HTTP_OK): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                ['data' => $data],
                'json',
                ['groups' => $groups]
            ),
            $statusCode
        );
    }

    /**
     * Clousure to render form errors.
     */
    protected function renderErrors(FormInterface $form, string $translatorDomain = 'main'): void
    {
        foreach ($form->getErrors(true) as $error) {
            if ($error instanceof FormError) {
                $cause = $error->getCause();
                if ($cause instanceof ConstraintViolationInterface) {
                    $this->addFlash(
                        'error',
                        sprintf(
                            '%s: [%s] %s',
                            $cause->getPropertyPath(),
                            implode(', ', array_values($error->getMessageParameters())),
                            $this->trans($error->getMessage(), $error->getMessageParameters(), $translatorDomain)
                        )
                    );
                }
            }
        }
    }
}
