<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Expense;
use App\Entity\ExpenseCategory;
use Carbon\CarbonImmutable;

readonly class ExpenseFactory extends BaseFactory implements ExpenseFactoryInterface
{
    public function createBlankObject(): Expense
    {
        return new Expense();
    }

    public function create(
        string $description,
        ExpenseCategory $expenseCategory,
        string $type,
        CarbonImmutable $date,
        int $cost,
        ?string $comments = null,
    ): Expense {
        $expense = new Expense();
        $expense->setDescription($description);
        $expense->setCategory($expenseCategory);
        $expense->setType($type);
        $expense->setDate($date);
        $expense->setCost($cost);
        $expense->setComments($comments);

        $this->validateObject($expense);

        return $expense;
    }
}
