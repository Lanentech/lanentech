<?php

declare(strict_types=1);

namespace App\Factory;

/**
 * @template T of object
 */
interface CanCreateBlankObjectInterface
{
    /**
     * @return T
     */
    public function createBlankObject();
}
