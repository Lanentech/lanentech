<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Company;
use App\Repository\Traits\CanPersistAndFlushInterface;

/**
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface CompanyRepositoryInterface extends CanPersistAndFlushInterface
{
}
