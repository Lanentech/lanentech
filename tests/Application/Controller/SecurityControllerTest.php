<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller;

use App\DataFixtures\Test\UserFixtures;
use App\Entity\User;
use App\Tests\TestCase\ApplicationTestCase;
use PHPUnit\Framework\Attributes\TestWith;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Form;

class SecurityControllerTest extends ApplicationTestCase
{
    private function populateLoginForm(
        Crawler $crawler,
        ?string $username = UserFixtures::NON_ADMIN_USER_USERNAME,
        ?string $password = 'password',
    ): Form {
        $form = $crawler->filter('form')->form();

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
        $this->assertStringContainsString('Logout', $this->client->getResponse()->getContent());
    }

    public function testUserCanLogoutSuccessfullyAfterLoggingIn(): void
    {
        /** @var User|null $user */
        if (!$user = $this->userRepository->findOneByUsername(UserFixtures::NON_ADMIN_USER_USERNAME)) {
            $this->fail(sprintf('Expected user with username %s to exist', UserFixtures::NON_ADMIN_USER_USERNAME));
        }

        $this->assertNull($user->getLastLoggedIn());

        $crawler = $this->client->request('GET', '/login');
        $loginForm = $this->populateLoginForm($crawler);

        $this->client->submit($loginForm);
        $this->assertResponseRedirects('/');
        $this->client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('span.logout');

        $this->client->clickLink('Logout');
        $this->assertResponseRedirects('/');
        $this->client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('span', 'Login');

        /** @var User $user */
        $user = $this->userRepository->findOneByUsername(UserFixtures::NON_ADMIN_USER_USERNAME);
        $this->assertNotNull($user->getLastLoggedIn());
    }
}
