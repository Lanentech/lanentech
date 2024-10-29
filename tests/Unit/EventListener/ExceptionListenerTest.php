<?php

declare(strict_types=1);

namespace App\Tests\Unit\EventListener;

use App\EventListener\ExceptionListener;
use App\Tests\TestCase\UnitTestCase;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExceptionListenerTest extends UnitTestCase
{
    use MockeryPHPUnitIntegration;

    private TranslatorInterface|m\MockInterface $translator;

    private ExceptionListener $sut;

    protected function setUp(): void
    {
        $this->translator = m::mock(TranslatorInterface::class);

        $this->sut = new ExceptionListener(
            $this->translator,
        );
    }

    public function testOnKernelExceptionWhenUnexpectedExceptionGiven(): void
    {
        $event = new ExceptionEvent(
            kernel: m::mock(HttpKernelInterface::class),
            request: m::mock(Request::class),
            requestType: 1,
            e: new BadRequestHttpException(),
        );

        $this->translator->expects('trans')->never();

        $this->sut->onKernelException($event);
    }

    public function testOnKernelExceptionHandlesAccessDeniedHttpExceptionCorrectly(): void
    {
        $event = new ExceptionEvent(
            kernel: m::mock(HttpKernelInterface::class),
            request: m::mock(Request::class),
            requestType: 1,
            e: new AccessDeniedHttpException(),
        );

        $this->translator->expects()
            ->trans('security.access_denied')
            ->andReturn('Access Denied: You do not have permission to access this page.');

        $this->sut->onKernelException($event);

        $response = $event->getResponse();

        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertStringContainsString(
            'Access Denied: You do not have permission to access this page.',
            $response->getContent(),
        );
    }
}
