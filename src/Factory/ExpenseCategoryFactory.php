<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\ExpenseCategory;

readonly class ExpenseCategoryFactory extends BaseFactory implements ExpenseCategoryFactoryInterface
{
    public function create(
        string $name,
        string $description,
    ): ExpenseCategory {
        $expenseCategory = new ExpenseCategory();
        $expenseCategory->setName($name);
        $expenseCategory->setDescription($description);

        $this->validateObject($expenseCategory);

        return $expenseCategory;
    }
}
