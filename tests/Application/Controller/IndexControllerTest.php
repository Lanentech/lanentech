<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller;

use App\Tests\TestCase\ApplicationTestCase;

class IndexControllerTest extends ApplicationTestCase
{
    public function testUserCanLoginSuccessfully(): void
    {
        $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Lanentech Homepage', $this->client->getResponse()->getContent());
    }
}
