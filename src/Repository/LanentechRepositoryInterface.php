<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Lanentech;
use App\Repository\Traits\CanPersistAndFlushInterface;

/**
 * @method Lanentech|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lanentech|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lanentech[]    findAll()
 * @method Lanentech[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface LanentechRepositoryInterface extends CanPersistAndFlushInterface
{
}
