<?php

declare(strict_types=1);

namespace App\Repository\Traits;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use LogicException;

trait CanPersistAndFlush
{
    public function persist(User $user): void
    {
        if (!method_exists(static::class, 'getEntityManager')) {
            throw new LogicException(
                sprintf(
                    "Are you sure you're using this trait within a Repository that extends '%s'?",
                    ServiceEntityRepository::class,
                )
            );
        }

        $this->getEntityManager()->persist($user);
    }

    public function flush(): void
    {
        if (!method_exists(static::class, 'getEntityManager')) {
            throw new LogicException(
                sprintf(
                    "Are you sure you're using this trait within a Repository that extends '%s'?",
                    ServiceEntityRepository::class,
                )
            );
        }

        $this->getEntityManager()->flush();
    }
}
