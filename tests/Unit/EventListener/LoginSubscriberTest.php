<?php

declare(strict_types=1);

namespace App\Tests\Unit\EventListener;

use App\Entity\User;
use App\EventListener\LoginSubscriber;
use App\Repository\UserRepositoryInterface;
use App\Tests\TestCase\UnitTestCase;
use Carbon\CarbonImmutable;
use Mockery as m;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LoginSubscriberTest extends UnitTestCase
{
    private m\MockInterface|RouterInterface $router;
    private m\MockInterface|UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->router = m::mock(RouterInterface::class);
        $this->userRepository = m::mock(UserRepositoryInterface::class);
    }

    private function fixture(): LoginSubscriber
    {
        return new LoginSubscriber(
            $this->router,
            $this->userRepository,
        );
    }

    public function testGetSubscribedEvents(): void
    {
        $expected = [
            LoginSuccessEvent::class => [
                ['updateLastLoggedInOnUser', 0],
                ['redirectAdminUser', -10],
            ],
        ];

        $result = $this->fixture()::getSubscribedEvents();

        $this->assertEquals($expected, $result);
    }

    public function testUpdateLastLoggedInOnUser(): void
    {
        $now = new CarbonImmutable();

        $user = new User();
        $user->setUsername('dummy-username');
        $user->setEmail('dummy-email-address@lanentech.co.uk');
        $user->setPassword('dummy-password');
        $user->setCreatedAt($now);
        $user->setUpdatedAt($now);

        $event = m::mock(LoginSuccessEvent::class);
        $event->expects()->getUser()->andReturn($user);

        $this->userRepository->expects()->save();

        $this->assertNull($user->getLastLoggedIn());
        $this->fixture()->updateLastLoggedInOnUser($event);
        $this->assertNotNull($user->getLastLoggedIn());
    }
}
