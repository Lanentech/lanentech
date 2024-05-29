<?php

declare(strict_types=1);

namespace App\Repository\Traits;

interface SupportsBatchFetchingInterface
{
    /**
     * @return object[]
     */
    public function fetchBatch(int $offset, int $limit): array;
}
