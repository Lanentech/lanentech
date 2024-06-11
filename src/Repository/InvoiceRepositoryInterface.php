<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Invoice;
use App\Repository\Traits\CanPersistAndFlushInterface;

/**
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface InvoiceRepositoryInterface extends CanPersistAndFlushInterface
{
}
