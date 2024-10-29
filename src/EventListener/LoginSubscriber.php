<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Carbon\CarbonImmutable;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

readonly class LoginSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private RouterInterface $router,
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => [
                ['updateLastLoggedInOnUser', 0],
                ['redirectAdminUser', -10],
            ],
        ];
    }

    public function updateLastLoggedInOnUser(LoginSuccessEvent $event): void
    {
        /** @var User $user */
        $user = $event->getUser();
        $user->setLastLoggedIn(new CarbonImmutable());

        $this->userRepository->save();
    }

    public function redirectAdminUser(LoginSuccessEvent $event): void
    {
        /** @var User $user */
        $user = $event->getUser();

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $response = new RedirectResponse($this->router->generate('admin_index'));

            $event->getRequest()->getSession()->set('_security_main', serialize($response));
            $event->setResponse($response);
        }
    }
}
