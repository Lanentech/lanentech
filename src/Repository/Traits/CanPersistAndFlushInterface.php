<?php

declare(strict_types=1);

namespace App\Repository\Traits;

use App\Entity\User;

interface CanPersistAndFlushInterface
{
    public function persist(User $user): void;

    public function flush(): void;
}
