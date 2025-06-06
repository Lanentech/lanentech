<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Expense;
use App\Entity\ExpenseCategory;
use Carbon\CarbonImmutable;

/**
 * @extends CanCreateBlankObjectInterface<Expense>
 */
interface ExpenseFactoryInterface extends CanCreateBlankObjectInterface
{
    public function create(
        string $description,
        ExpenseCategory $expenseCategory,
        string $type,
        CarbonImmutable $date,
        int $cost,
        ?string $comments = null,
    ): Expense;
}
