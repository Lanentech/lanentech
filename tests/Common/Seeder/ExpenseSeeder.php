<?php

declare(strict_types=1);

namespace App\Tests\Common\Seeder;

use App\DataFixtures\ExpenseCategoryFixtures;
use App\Entity\Const\Expense as ExpenseConstants;
use App\Entity\Expense;
use App\Factory\ExpenseFactoryInterface;
use App\Repository\ExpenseCategoryRepositoryInterface;
use Carbon\CarbonImmutable;

trait ExpenseSeeder
{
    /**
     * When seeding, if you wish to override the default Expense Category used, please pass in the name
     * of the Expense category you wish to use.
     */
    public function seedExpense(array $overrides = []): Expense
    {
        $expenseCategoryRepositoryPropertyName = 'expenseCategoryRepository';
        $expenseFactoryPropertyName = 'expenseFactory';

        $requiredProperties = [
            $expenseCategoryRepositoryPropertyName => ExpenseCategoryRepositoryInterface::class,
            $expenseFactoryPropertyName => ExpenseFactoryInterface::class,
        ];

        foreach ($requiredProperties as $propertyName => $className) {
            if (!property_exists($this, $propertyName)) {
                $this->fail(
                    sprintf(
                        'To use the %s trait, you need to ensure you have injected the %s into your test class, ' .
                        'under a property called "%s".',
                        ExpenseSeeder::class,
                        $className,
                        $propertyName,
                    ),
                );
            }
        }

        $expenseCategoryName = $overrides['expenseCategory'] ??
            ExpenseCategoryFixtures::CAR_VAN_AND_TRAVEL_EXPENSES_NAME;

        if (null === $expenseCategory = $this->expenseCategoryRepository->findOneByName($expenseCategoryName)) {
            $this->fail(sprintf('Cannot seed Expense, as cannot find Expense using name "%s"', $expenseCategoryName));
        }

        $expense = $this->expenseFactory->create(
            description: $overrides['description'] ?? 'Fake Description',
            expenseCategory: $expenseCategory,
            type: $overrides['type'] ?? ExpenseConstants::TYPE_BUSINESS_COST,
            date: $overrides['date'] ?? CarbonImmutable::now(),
            cost: $overrides['cost'] ?? 4999,
            comments: $overrides['comments'] ?? '',
        );

        $this->expenseRepository->save($expense);

        return $expense;
    }
}
