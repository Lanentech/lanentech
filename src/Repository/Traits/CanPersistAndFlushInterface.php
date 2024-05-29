<?php

declare(strict_types=1);

namespace App\Repository\Traits;

interface CanPersistAndFlushInterface
{
    public function persist(object $object): void;

    public function flush(): void;
}
