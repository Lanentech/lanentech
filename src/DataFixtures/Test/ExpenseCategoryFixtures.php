<?php

declare(strict_types=1);

namespace App\DataFixtures\Test;

use App\DataFixtures\ExpenseCategoryFixtures as ApplicationExpenseCategoryFixtures;

class ExpenseCategoryFixtures extends ApplicationExpenseCategoryFixtures
{
    public static function getGroups(): array
    {
        return ['test-fixture'];
    }
}
