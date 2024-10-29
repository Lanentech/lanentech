<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DataManagementLog;

interface DataManagementLogRepositoryInterface
{
    public function findOneById(int $id): ?DataManagementLog;

    public function findOneByFilename(string $filename): ?DataManagementLog;

    /**
     * @return DataManagementLog[]
     */
    public function findAll(): array;

    /**
     * @return DataManagementLog[]
     */
    public function fetchBatch(int $offset, int $limit): array;

    public function delete(DataManagementLog $object): void;

    public function save(?DataManagementLog $object = null): void;
}
