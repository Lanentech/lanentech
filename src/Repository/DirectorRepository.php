<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Director;
use App\Repository\Traits\CanPersistAndFlush;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Director>
 */
class DirectorRepository extends ServiceEntityRepository implements DirectorRepositoryInterface
{
    use CanPersistAndFlush;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Director::class);
    }
}
