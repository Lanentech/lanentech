<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Lanentech;

interface LanentechRepositoryInterface
{
    public function findOneById(int $id): ?Lanentech;

    /**
     * @return Lanentech[]
     */
    public function findAll(): array;

    /**
     * @return Lanentech[]
     */
    public function fetchBatch(int $offset, int $limit): array;

    public function delete(Lanentech $object): void;

    public function save(?Lanentech $object = null): void;
}
