<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller;

use App\DataFixtures\Test\UserFixtures;
use App\Factory\RepeatCostFactoryInterface;
use App\Repository\RepeatCostRepositoryInterface;
use App\Tests\Common\Csrf\CsrfTokenManagerMock;
use App\Tests\Common\Seeder\RepeatCostSeeder;
use App\Tests\TestCase\ApplicationTestCase;
use Carbon\Carbon;

class RepeatCostControllerTest extends ApplicationTestCase
{
    use RepeatCostSeeder;

    private readonly RepeatCostFactoryInterface $repeatCostFactory;
    private readonly RepeatCostRepositoryInterface $repeatCostRepository;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var RepeatCostRepositoryInterface $repeatCostRepository */
        $repeatCostRepository = $this->container->get(RepeatCostRepositoryInterface::class);
        $this->repeatCostRepository = $repeatCostRepository;

        /** @var RepeatCostFactoryInterface $repeatCostFactory */
        $repeatCostFactory = $this->container->get(RepeatCostFactoryInterface::class);
        $this->repeatCostFactory = $repeatCostFactory;
    }

    public function testNonAdminCannotAccessRepeatCostsIndexPage(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('GET', '/admin/repeat-cost');

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testIndexRouteRendersPageSuccessfully(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('GET', '/admin/repeat-cost');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Repeat Costs', $this->client->getResponse()->getContent());
    }

    public function testNonAdminCannotAccessRepeatCostsGetNewPage(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('GET', '/admin/repeat-cost/new');

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testNewRouteRendersPageSuccessfully(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->request('GET', '/admin/repeat-cost/new');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Create New Repeat Cost', $this->client->getResponse()->getContent());
    }

    public function testNonAdminCannotAccessRepeatCostsPostNewPage(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('POST', '/admin/repeat-cost/new');

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testNewRouteWithSuccessfulFormSubmission(): void
    {
        $now = Carbon::create(2024, 10, 7, 10, 15, 17);
        Carbon::setTestNow($now);

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('POST', '/admin/repeat-cost/new');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Create New Repeat Cost', $this->client->getResponse()->getContent());

        $this->client->submitForm('Save', [
            'repeat_cost[description]' => 'Description Value',
            'repeat_cost[cost]' => 100,
            'repeat_cost[date]' => $now->format('d/m/Y'),
        ]);

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Repeat Cost', $responseContent);
        $this->assertStringContainsString('Description Value', $responseContent);
    }

    public function testNewRouteWhenFormSubmissionFailsValidation(): void
    {
        $now = Carbon::create(2024, 10, 7, 10, 15, 17);
        Carbon::setTestNow($now);

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('POST', '/admin/repeat-cost/new');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Create New Repeat Cost', $this->client->getResponse()->getContent());

        $this->client->submitForm('Save', [
            'repeat_cost[description]' => '',
            'repeat_cost[cost]' => 100,
            'repeat_cost[date]' => $now->format('d/m/Y'),
        ]);

        $response = $this->client->getResponse();
        $this->assertStringContainsString('Description cannot be empty', $response->getContent());
    }

    public function testNonAdminCannotAccessRepeatCostsShowPage(): void
    {
        $repeatCost = $this->seedRepeatCost();

        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('GET', sprintf('/admin/repeat-cost/%s', $repeatCost->getId()));

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testShowRouteSuccessfullyRendersPage(): void
    {
        $repeatCost = $this->seedRepeatCost(['description' => 'Test Description']);

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('GET', sprintf('/admin/repeat-cost/%s', $repeatCost->getId()));

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Repeat Cost', $responseContent);
        $this->assertStringContainsString('Test Description', $responseContent);
    }

    public function testNonAdminCannotAccessRepeatCostsEditPage(): void
    {
        $repeatCost = $this->seedRepeatCost();

        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('GET', sprintf('/admin/repeat-cost/%s/edit', $repeatCost->getId()));

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testEditRouteSuccessfullyRendersPage(): void
    {
        $repeatCost = $this->seedRepeatCost();

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('GET', sprintf('/admin/repeat-cost/%s/edit', $repeatCost->getId()));

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Edit Repeat Cost', $this->client->getResponse()->getContent());
    }

    public function testEditRouteWhenFormSubmissionFailsValidation(): void
    {
        $repeatCost = $this->seedRepeatCost();
        $repeatCostNewDescription = 'New Description';

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('GET', sprintf('/admin/repeat-cost/%s/edit', $repeatCost->getId()));

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Edit Repeat Cost', $this->client->getResponse()->getContent());

        $this->client->submitForm('Save', [
            'repeat_cost[description]' => $repeatCostNewDescription,
        ]);

        $this->assertResponseIsSuccessful();

        $repeatCost = $this->repeatCostRepository->findOneById($repeatCost->getId());
        $this->assertNotNull($repeatCost);
        $this->assertEquals($repeatCostNewDescription, $repeatCost->getDescription());
    }

    public function testNonAdminCannotAccessRepeatCostsDeleteFunctionality(): void
    {
        $repeatCost = $this->seedRepeatCost();

        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('POST', sprintf('/admin/repeat-cost/%s', $repeatCost->getId()), [
            '_token' => CsrfTokenManagerMock::APPLICATION_TEST_CSRF_TOKEN,
        ]);

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testDeleteRouteWithValidCsrfToken(): void
    {
        $repeatCostDescription = 'Test Description';
        $repeatCost = $this->seedRepeatCost(['description' => $repeatCostDescription]);

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('POST', sprintf('/admin/repeat-cost/%s', $repeatCost->getId()), [
            '_token' => CsrfTokenManagerMock::APPLICATION_TEST_CSRF_TOKEN,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertNull($this->repeatCostRepository->findOneByDescription($repeatCostDescription));
    }

    public function testDeleteRouteWithInvalidCsrfToken(): void
    {
        $repeatCost = $this->seedRepeatCost();

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('POST', sprintf('/admin/repeat-cost/%s', $repeatCost->getId()), [
            '_token' => 'invalid-token-value',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Repeat Costs', $this->client->getResponse()->getContent());
    }
}
