<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RepeatCost;

interface RepeatCostRepositoryInterface
{
    public function findOneById(int $id): ?RepeatCost;

    /**
     * @return RepeatCost[]
     */
    public function findAll(): array;

    public function findOneByDescription(string $description): ?RepeatCost;

    /**
     * @return RepeatCost[]
     */
    public function fetchBatch(int $offset, int $limit): array;

    public function delete(RepeatCost $object): void;

    public function save(?RepeatCost $object = null): void;
}
