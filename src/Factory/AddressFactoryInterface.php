<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Address;

interface AddressFactoryInterface
{
    public function create(
        string $houseNumber,
        string $street,
        string $townCity,
        string $postcode,
        string $country,
        ?string $houseName = null,
    ): Address;
}
