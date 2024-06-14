<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Billable;
use App\Repository\Traits\CanPersistAndFlushInterface;

/**
 * @method Billable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Billable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Billable[]    findAll()
 * @method Billable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface BillableRepositoryInterface extends CanPersistAndFlushInterface
{
}
