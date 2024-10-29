<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Billable;

interface BillableRepositoryInterface
{
    public function findOneById(int $id): ?Billable;

    /**
     * @return Billable[]
     */
    public function findAll(): array;

    /**
     * @return Billable[]
     */
    public function fetchBatch(int $offset, int $limit): array;

    public function delete(Billable $object): void;

    public function save(?Billable $object = null): void;
}
