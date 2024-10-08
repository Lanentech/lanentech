<?php

declare(strict_types=1);

namespace App\Tests\TestCase;

use App\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApplicationTestCase extends WebTestCase
{
    protected readonly ContainerInterface $container;
    protected readonly KernelBrowser $client;
    protected readonly UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->container = static::getContainer();
        $this->userRepository = $this->container->get(UserRepositoryInterface::class);
    }

    protected function loginAsUserWithEmail(string $email): void
    {
        $user = $this->userRepository->findOneByEmail($email);

        $this->client->loginUser($user);
    }
}
