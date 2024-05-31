<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DataManagementLog;
use App\Repository\Traits\CanPersistAndFlush;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataManagementLog>
 */
class DataManagementLogRepository extends ServiceEntityRepository implements DataManagementLogRepositoryInterface
{
    use CanPersistAndFlush;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataManagementLog::class);
    }
}
