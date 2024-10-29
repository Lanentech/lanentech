<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Company;

interface CompanyRepositoryInterface
{
    public function findOneById(int $id): ?Company;

    /**
     * @return Company[]
     */
    public function findAll(): array;

    /**
     * @return Company[]
     */
    public function fetchBatch(int $offset, int $limit): array;

    public function delete(Company $object): void;

    public function save(?Company $object = null): void;
}
