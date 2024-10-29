<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Director;

interface DirectorRepositoryInterface
{
    public function findOneById(int $id): ?Director;

    /**
     * @return Director[]
     */
    public function findAll(): array;

    /**
     * @return Director[]
     */
    public function fetchBatch(int $offset, int $limit): array;

    public function delete(Director $object): void;

    public function save(?Director $object = null): void;
}
