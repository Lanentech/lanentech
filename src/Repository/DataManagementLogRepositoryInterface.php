<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DataManagementLog;
use App\Repository\Traits\CanPersistAndFlushInterface;

/**
 * @method DataManagementLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataManagementLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataManagementLog[]    findAll()
 * @method DataManagementLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface DataManagementLogRepositoryInterface extends CanPersistAndFlushInterface
{
}
