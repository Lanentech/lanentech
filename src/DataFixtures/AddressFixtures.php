<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\AddressFactoryInterface;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends AbstractFixture
{
    public function __construct(
        private readonly AddressFactoryInterface $addressFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullyPopulatedAddressFixture($manager);
        $this->createMinimallyPopulatedAddressFixture($manager);

        $manager->flush();
    }

    private function createFullyPopulatedAddressFixture(ObjectManager $manager): void
    {
        $fullyPopulatedAddress = $this->addressFactory->create(
            houseNumber: '3',
            street: 'Primrose Lane',
            townCity: 'Hadfield',
            postcode: 'SK148NR',
            country: 'GBR',
            houseName: 'Farmendale'
        );

        $manager->persist($fullyPopulatedAddress);
    }

    private function createMinimallyPopulatedAddressFixture(ObjectManager $manager): void
    {
        $minimalPopulatedAddress = $this->addressFactory->create(
            houseNumber: '72',
            street: 'Playground Avenue',
            townCity: 'Macclesfield',
            postcode: 'SK57NT',
            country: 'GBR',
        );

        $manager->persist($minimalPopulatedAddress);
    }
}
