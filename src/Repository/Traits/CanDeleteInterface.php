<?php

declare(strict_types=1);

namespace App\Repository\Traits;

interface CanDeleteInterface
{
    public function delete(object $object): void;
}
