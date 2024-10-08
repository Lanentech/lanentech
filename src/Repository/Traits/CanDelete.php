<?php

declare(strict_types=1);

namespace App\Repository\Traits;

trait CanDelete
{
    public function delete(object $object): void
    {
        $this->getEntityManager()->remove($object);
    }
}
