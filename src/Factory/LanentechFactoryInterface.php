<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Director;
use App\Entity\Lanentech;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\Collection;

interface LanentechFactoryInterface
{
    /**
     * @param Collection<int, Director> $directors
     */
    public function create(
        string $name,
        int $companyNumber,
        CarbonImmutable $incorporationDate,
        Collection $directors,
    ): Lanentech;
}
