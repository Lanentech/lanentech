<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Address;
use App\Repository\Traits\CanPersistAndFlushInterface;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface AddressRepositoryInterface extends CanPersistAndFlushInterface
{
}
