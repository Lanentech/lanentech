<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Address;

readonly class AddressFactory extends BaseFactory implements AddressFactoryInterface
{
    public function create(
        string $houseNumber,
        string $street,
        string $townCity,
        string $postcode,
        string $country,
        ?string $houseName = null,
    ): Address {
        $address = new Address();
        $address->setHouseName($houseName);
        $address->setHouseNumber($houseNumber);
        $address->setStreet($street);
        $address->setTownCity($townCity);
        $address->setPostcode($postcode);
        $address->setCountry($country);

        $this->validateObject($address);

        return $address;
    }
}
