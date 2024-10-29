<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ExpenseCategory;

interface ExpenseCategoryRepositoryInterface
{
    public function findOneById(int $id): ?ExpenseCategory;

    public function findOneByName(string $name): ?ExpenseCategory;

    /**
     * @return ExpenseCategory[]
     */
    public function findAll(): array;

    /**
     * @return ExpenseCategory[]
     */
    public function fetchBatch(int $offset, int $limit): array;

    public function delete(ExpenseCategory $object): void;

    public function save(?ExpenseCategory $object = null): void;
}
