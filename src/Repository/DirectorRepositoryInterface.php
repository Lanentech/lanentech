<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Director;
use App\Repository\Traits\CanPersistAndFlushInterface;

/**
 * @method Director|null find($id, $lockMode = null, $lockVersion = null)
 * @method Director|null findOneBy(array $criteria, array $orderBy = null)
 * @method Director[]    findAll()
 * @method Director[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface DirectorRepositoryInterface extends CanPersistAndFlushInterface
{
}
