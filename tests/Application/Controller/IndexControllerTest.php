<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller;

use App\DataFixtures\Test\UserFixtures;
use App\Tests\TestCase\ApplicationTestCase;

class IndexControllerTest extends ApplicationTestCase
{
    public function testUserCanLoginSuccessfully(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('<h1>Lanentech Homepage</h1>', $this->client->getResponse()->getContent());
    }
}
