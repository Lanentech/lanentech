<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RepeatCost;
use App\Repository\Traits\CanPersistAndFlushInterface;

/**
 * @method RepeatCost|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepeatCost|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepeatCost[]    findAll()
 * @method RepeatCost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface RepeatCostRepositoryInterface extends CanPersistAndFlushInterface
{
}
