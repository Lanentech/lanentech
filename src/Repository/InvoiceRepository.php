<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Invoice;
use App\Repository\Traits\CanPersistAndFlush;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invoice>
 */
class InvoiceRepository extends ServiceEntityRepository implements InvoiceRepositoryInterface
{
    use CanPersistAndFlush;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoice::class);
    }
}
