<?php

declare(strict_types=1);

namespace App\Tests\TestCase;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApplicationTestCase extends WebTestCase
{
    protected KernelBrowser $client;
    protected ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->container = static::getContainer();
    }
}
