<?php

declare(strict_types=1);

namespace App\Entity\Traits;

trait SetId
{
    /**
     * @internal Please only use this within unit tests.
     */
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }
}
