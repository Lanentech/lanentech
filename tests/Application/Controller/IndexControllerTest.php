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
        $this->assertStringContainsString(
            'Professional<br />Website Development',
            $this->client->getResponse()->getContent(),
        );
    }

    public function testNonAdminCannotAccessAdminOnlyPage(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('GET', '/admin');

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testAdminUserCanSeeAdminPageSuccessfully(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->request('GET', '/admin');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Manage Expenses', $this->client->getResponse()->getContent());
    }
}
