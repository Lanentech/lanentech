<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RepeatCost;
use App\Repository\Traits\CanPersistAndFlush;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RepeatCost>
 */
class RepeatCostRepository extends ServiceEntityRepository implements RepeatCostRepositoryInterface
{
    use CanPersistAndFlush;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepeatCost::class);
    }
}
