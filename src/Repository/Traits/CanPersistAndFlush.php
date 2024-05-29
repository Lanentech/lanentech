<?php

declare(strict_types=1);

namespace App\Repository\Traits;

trait CanPersistAndFlush
{
    public function persist(object $object): void
    {
        $this->getEntityManager()->persist($object);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
