<?php

declare(strict_types=1);

namespace App\Tests\Unit\EventListener;

use App\Entity\User;
use App\EventListener\LoginSubscriber;
use App\Repository\UserRepositoryInterface;
use App\Tests\TestCase\UnitTestCase;
use Carbon\CarbonImmutable;
use Mockery as m;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LoginSubscriberTest extends UnitTestCase
{
    private m\MockInterface|UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = m::mock(UserRepositoryInterface::class);
    }

    private function fixture(): LoginSubscriber
    {
        return new LoginSubscriber(
            $this->userRepository,
        );
    }

    public function testGetSubscribedEvents(): void
    {
        $expected = [
            LoginSuccessEvent::class => [
                ['updateLastLoggedInOnUser', 0],
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

        $this->userRepository->expects()->flush();

        $this->assertNull($user->getLastLoggedIn());
        $this->fixture()->updateLastLoggedInOnUser($event);
        $this->assertNotNull($user->getLastLoggedIn());
    }
}
