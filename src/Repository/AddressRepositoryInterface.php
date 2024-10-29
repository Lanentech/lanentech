<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Address;

interface AddressRepositoryInterface
{
    public function findOneById(int $id): ?Address;

    /**
     * @return Address[]
     */
    public function findAll(): array;

    /**
     * @return Address[]
     */
    public function fetchBatch(int $offset, int $limit): array;

    public function delete(Address $object): void;

    public function save(?Address $object = null): void;
}
