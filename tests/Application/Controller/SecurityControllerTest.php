<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use App\Tests\TestCase\ApplicationTestCase;
use PHPUnit\Framework\Attributes\TestWith;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Form;

class SecurityControllerTest extends ApplicationTestCase
{
    private function populateLoginForm(
        Crawler $crawler,
        ?string $username = 'test-user',
        ?string $password = 'password',
    ): Form {
        $form = $crawler->selectButton('Login')->form();

        if ($username) {
            $form['_username'] = $username;
        }

        if ($password) {
            $form['_password'] = $password;
        }

        return $form;
    }

    #[TestWith(['', ''])]
    #[TestWith([null, null])]
    #[TestWith(['invalid-username', 'invalid-password'])]
    public function testUserCannotLoginAsCredentialsAreIncorrect(?string $username, ?string $password): void
    {
        $crawler = $this->client->request('GET', '/login');
        $loginForm = $this->populateLoginForm($crawler, $username, $password);

        $this->client->submit($loginForm);
        $this->client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Invalid credentials', $this->client->getResponse()->getContent());
    }

    public function testUserCanLoginSuccessfully(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $loginForm = $this->populateLoginForm($crawler);

        $this->client->submit($loginForm);
        $this->assertResponseRedirects('/');
        $this->client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Hi Test User', $this->client->getResponse()->getContent());
    }

    public function testUserCanLogoutSuccessfullyAfterLoggingIn(): void
    {
        /** @var User|null $user */
        if (!$user = $this->container->get(UserRepositoryInterface::class)->findOneBy(['username' => 'test-user'])) {
            $this->fail('Expected user with username test-user to exist');
        }

        $this->assertNull($user->getLastLoggedIn());

        $crawler = $this->client->request('GET', '/login');
        $loginForm = $this->populateLoginForm($crawler);

        $this->client->submit($loginForm);
        $this->assertResponseRedirects('/');
        $this->client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.logout-button');

        $this->client->clickLink('Logout');
        $this->assertResponseRedirects('/');
        $this->client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('a', 'Login');

        /** @var User $user */
        $user = $this->container->get(UserRepositoryInterface::class)->findOneBy(['username' => 'test-user']);
        $this->assertNotNull($user->getLastLoggedIn());
    }
}
