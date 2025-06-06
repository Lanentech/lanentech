<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller;

use App\DataFixtures\ExpenseCategoryFixtures;
use App\DataFixtures\Test\UserFixtures;
use App\Entity\Const\Expense;
use App\Factory\ExpenseFactoryInterface;
use App\Repository\ExpenseCategoryRepositoryInterface;
use App\Repository\ExpenseRepositoryInterface;
use App\Tests\Common\Csrf\CsrfTokenManagerMock;
use App\Tests\Common\Seeder\ExpenseSeeder;
use App\Tests\TestCase\ApplicationTestCase;
use Carbon\Carbon;

class ExpenseControllerTest extends ApplicationTestCase
{
    use ExpenseSeeder;

    private readonly ExpenseCategoryRepositoryInterface $expenseCategoryRepository;
    private readonly ExpenseFactoryInterface $expenseFactory;
    private readonly ExpenseRepositoryInterface $expenseRepository;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var ExpenseRepositoryInterface $expenseRepository */
        $expenseRepository = $this->container->get(ExpenseRepositoryInterface::class);
        $this->expenseRepository = $expenseRepository;

        /** @var ExpenseCategoryRepositoryInterface $expenseCategoryRepository */
        $expenseCategoryRepository = $this->container->get(ExpenseCategoryRepositoryInterface::class);
        $this->expenseCategoryRepository = $expenseCategoryRepository;

        /** @var ExpenseFactoryInterface $expenseFactory */
        $expenseFactory = $this->container->get(ExpenseFactoryInterface::class);
        $this->expenseFactory = $expenseFactory;
    }

    public function testNonAdminCannotAccessExpensesIndexPage(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('GET', '/admin/expense');

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testIndexRouteRendersPageSuccessfully(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('GET', '/admin/expense');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Expenses', $this->client->getResponse()->getContent());
    }

    public function testNonAdminCannotAccessExpensesGetNewPage(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('GET', '/admin/expense/new');

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testNewRouteRendersPageSuccessfully(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->request('GET', '/admin/expense/new');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Create New Expense', $this->client->getResponse()->getContent());
    }

    public function testNonAdminCannotAccessExpensesPostNewPage(): void
    {
        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('POST', '/admin/expense/new');

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testNewRouteWithSuccessfulFormSubmission(): void
    {
        $expenseCategory = $this->expenseCategoryRepository->findOneByName(
            ExpenseCategoryFixtures::OFFICE_PROPERTY_AND_EQUIPMENT_NAME,
        );

        if ($expenseCategory === null) {
            $this->fail('Expected ExpenseCategory to exist. Cannot submit form');
        }

        $now = Carbon::create(2024, 10, 7, 10, 15, 17);
        Carbon::setTestNow($now);

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('POST', '/admin/expense/new');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Create New Expense', $this->client->getResponse()->getContent());

        $this->client->submitForm('Save', [
            'expense[description]' => 'Description Value',
            'expense[category]' => $expenseCategory->getId(),
            'expense[type]' => Expense::TYPE_BUSINESS_COST,
            'expense[cost]' => 100,
            'expense[date]' => $now->format('d/m/Y'),
            'expense[comments]' => 'This is a comment about this expense.',
        ]);

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Expense', $responseContent);
        $this->assertStringContainsString('Comments', $responseContent);
        $this->assertStringContainsString('This is a comment about this expense.', $responseContent);
    }

    public function testNewRouteWhenFormSubmissionFailsValidation(): void
    {
        $expenseCategory = $this->expenseCategoryRepository->findOneByName(
            ExpenseCategoryFixtures::OFFICE_PROPERTY_AND_EQUIPMENT_NAME,
        );

        if ($expenseCategory === null) {
            $this->fail('Expected ExpenseCategory to exist. Cannot submit form');
        }

        $now = Carbon::create(2024, 10, 7, 10, 15, 17);
        Carbon::setTestNow($now);

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('POST', '/admin/expense/new');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Create New Expense', $this->client->getResponse()->getContent());

        $this->client->submitForm('Save', [
            'expense[description]' => '',
            'expense[category]' => $expenseCategory->getId(),
            'expense[type]' => Expense::TYPE_BUSINESS_COST,
            'expense[cost]' => 100,
            'expense[date]' => $now->format('d/m/Y'),
            'expense[comments]' => 'This is a comment about this expense.',
        ]);

        $response = $this->client->getResponse();
        $this->assertStringContainsString('Description cannot be empty', $response->getContent());
    }

    public function testNonAdminCannotAccessExpensesShowPage(): void
    {
        $expense = $this->seedExpense();

        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('GET', sprintf('/admin/expense/%s', $expense->getId()));

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testShowRouteSuccessfullyRendersPage(): void
    {
        $expense = $this->seedExpense(['comments' => 'This is a comment about this expense.']);

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('GET', sprintf('/admin/expense/%s', $expense->getId()));

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Expense', $responseContent);
        $this->assertStringContainsString('Comments', $responseContent);
        $this->assertStringContainsString('This is a comment about this expense.', $responseContent);
    }

    public function testNonAdminCannotAccessExpensesEditPage(): void
    {
        $expense = $this->seedExpense();

        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('GET', sprintf('/admin/expense/%s/edit', $expense->getId()));

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testEditRouteSuccessfullyRendersPage(): void
    {
        $expense = $this->seedExpense();

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('GET', sprintf('/admin/expense/%s/edit', $expense->getId()));

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Edit Expense', $this->client->getResponse()->getContent());
    }

    public function testEditRouteWhenFormSubmissionFailsValidation(): void
    {
        $expense = $this->seedExpense();
        $expenseNewDescription = 'New Description';

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('GET', sprintf('/admin/expense/%s/edit', $expense->getId()));

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Edit Expense', $this->client->getResponse()->getContent());

        $this->client->submitForm('Save', [
            'expense[description]' => $expenseNewDescription,
        ]);

        $this->assertResponseIsSuccessful();

        $expense = $this->expenseRepository->findOneById($expense->getId());
        $this->assertNotNull($expense);
        $this->assertEquals($expenseNewDescription, $expense->getDescription());
    }

    public function testNonAdminCannotAccessExpensesDeleteFunctionality(): void
    {
        $expense = $this->seedExpense();

        $this->loginAsUserWithEmail(UserFixtures::NON_ADMIN_USER_EMAIL);

        $this->client->request('POST', sprintf('/admin/expense/%s', $expense->getId()), [
            '_token' => CsrfTokenManagerMock::APPLICATION_TEST_CSRF_TOKEN,
        ]);

        $this->assertResponseStatusCodeSame(403);
        $this->assertStringContainsString('Access Denied', $this->client->getResponse()->getContent());
    }

    public function testDeleteRouteWithValidCsrfToken(): void
    {
        $expenseDescription = 'Test Description';
        $expense = $this->seedExpense(['description' => $expenseDescription]);

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('POST', sprintf('/admin/expense/%s', $expense->getId()), [
            '_token' => CsrfTokenManagerMock::APPLICATION_TEST_CSRF_TOKEN,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertNull($this->expenseRepository->findOneByDescription($expenseDescription));
    }

    public function testDeleteRouteWithInvalidCsrfToken(): void
    {
        $expense = $this->seedExpense();

        $this->loginAsUserWithEmail(UserFixtures::ADMIN_USER_EMAIL);

        $this->client->followRedirects();
        $this->client->request('POST', sprintf('/admin/expense/%s', $expense->getId()), [
            '_token' => 'invalid-token-value',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Expenses', $this->client->getResponse()->getContent());
    }
}
