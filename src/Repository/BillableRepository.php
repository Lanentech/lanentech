<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Billable;
use App\Repository\Traits\CanPersistAndFlush;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Billable>
 */
class BillableRepository extends ServiceEntityRepository implements BillableRepositoryInterface
{
    use CanPersistAndFlush;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Billable::class);
    }
}
