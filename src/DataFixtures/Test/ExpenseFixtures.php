<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\DataFixtures\ExpenseFixtures as ApplicationExpenseFixtures;

class ExpenseFixtures extends ApplicationExpenseFixtures
{
    public static function getGroups(): array
    {
        return ['test-fixture'];
    }

    public function getDependencies(): array
    {
        return [
            ExpenseCategoryFixtures::class,
        ];
    }
}
