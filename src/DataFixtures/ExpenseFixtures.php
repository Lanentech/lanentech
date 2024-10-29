<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Const\Expense as ExpenseConstants;
use App\Entity\ExpenseCategory;
use App\Factory\ExpenseFactoryInterface;
use App\Repository\ExpenseRepositoryInterface;
use Carbon\CarbonImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExpenseFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly ExpenseFactoryInterface $factory,
        private readonly ExpenseRepositoryInterface $repository,
    ) {
    }

    public function getDependencies(): array
    {
        return [
            ExpenseCategoryFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullyPopulatedExpenseFixture();
        $this->createMinimallyPopulatedExpenseFixture();
    }

    private function createFullyPopulatedExpenseFixture(): void
    {
        if (!$date = CarbonImmutable::create(year: 2024, month: 2, day: 18, hour: 15, minute: 22, second: 52)) {
            $this->throwExceptionWhenDateCannotBeCreated('Date');
        }

        $fullyPopulatedExpense = $this->factory->create(
            description: 'Accountancy Fee for Year End Accounts',
            expenseCategory: $this->getReference(
                ExpenseCategoryFixtures::LEGAL_AND_FINANCIAL_COSTS,
                ExpenseCategory::class,
            ),
            type: ExpenseConstants::TYPE_BUSINESS_COST,
            date: $date,
            cost: 59999,
            comments: 'This is the annual fee for the company, for the accountant to submit the companies accounts',
        );

        $this->repository->save($fullyPopulatedExpense);
    }

    private function createMinimallyPopulatedExpenseFixture(): void
    {
        if (!$date = CarbonImmutable::create(year: 2024, month: 2, day: 23, hour: 11, minute: 49, second: 13)) {
            $this->throwExceptionWhenDateCannotBeCreated('Date');
        }

        $minimallyPopulatedExpense = $this->factory->create(
            description: 'Symfony 7 online course',
            expenseCategory: $this->getReference(
                ExpenseCategoryFixtures::TRAINING_COURSES,
                ExpenseCategory::class,
            ),
            type: ExpenseConstants::TYPE_DIRECTORS_EXPENSE,
            date: $date,
            cost: 14999,
        );

        $this->repository->save($minimallyPopulatedExpense);
    }
}
