<?php

declare(strict_types=1);

namespace App\Repository\Traits;

trait SupportsBatchFetching
{
    public function fetchBatch(int $offset, int $limit): array
    {
        /** @var object[] $results */
        $results = $this->createQueryBuilder('e')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return $results;
    }
}
