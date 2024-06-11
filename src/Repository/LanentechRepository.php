<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Lanentech;
use App\Repository\Traits\CanPersistAndFlush;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lanentech>
 */
class LanentechRepository extends ServiceEntityRepository implements LanentechRepositoryInterface
{
    use CanPersistAndFlush;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lanentech::class);
    }
}
