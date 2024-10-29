<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Expense;

interface ExpenseRepositoryInterface
{
    public function findOneById(int $id): ?Expense;

    public function findOneByDescription(string $description): ?Expense;

    /**
     * @return Expense[]
     */
    public function findAll(): array;

    /**
     * @return Expense[]
     */
    public function fetchBatch(int $offset, int $limit): array;

    public function delete(Expense $object): void;

    public function save(?Expense $object = null): void;
}
