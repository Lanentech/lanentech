<?php

declare(strict_types=1);

namespace App\Entity\Traits;

trait GetId
{
    public function getId(): ?int
    {
        return $this->id;
    }
}
