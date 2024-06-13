<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\ExpenseCategory;

interface ExpenseCategoryFactoryInterface
{
    public function create(
        string $name,
        string $description,
    ): ExpenseCategory;
}
