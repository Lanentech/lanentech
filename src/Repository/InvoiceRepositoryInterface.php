<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Invoice;

interface InvoiceRepositoryInterface
{
    public function findOneById(int $id): ?Invoice;

    /**
     * @return Invoice[]
     */
    public function findAll(): array;

    /**
     * @return Invoice[]
     */
    public function fetchBatch(int $offset, int $limit): array;

    public function delete(Invoice $object): void;

    public function save(?Invoice $object = null): void;
}
