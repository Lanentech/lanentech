<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class ExceptionListener
{
    public function __construct(
        private TranslatorInterface $translator,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AccessDeniedHttpException) {
            $response = new Response();
            $response->setContent($this->translator->trans('security.access_denied'));
            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            $event->setResponse($response);
        }
    }
}
