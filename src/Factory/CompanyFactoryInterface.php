<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Address;
use App\Entity\Company;

interface CompanyFactoryInterface
{
    public function create(
        string $name,
        string $ident,
        string $type,
        int $companyNumber,
        ?Address $address = null,
    ): Company;
}
