<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\AddressFactoryInterface;
use App\Repository\AddressRepositoryInterface;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends AbstractFixture
{
    public function __construct(
        private readonly AddressFactoryInterface $factory,
        private readonly AddressRepositoryInterface $repository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullyPopulatedAddressFixture();
        $this->createMinimallyPopulatedAddressFixture();
    }

    private function createFullyPopulatedAddressFixture(): void
    {
        $fullyPopulatedAddress = $this->factory->create(
            houseNumber: '3',
            street: 'Primrose Lane',
            townCity: 'Hadfield',
            postcode: 'SK148NR',
            country: 'GBR',
            houseName: 'Farmendale'
        );

        $this->repository->save($fullyPopulatedAddress);
    }

    private function createMinimallyPopulatedAddressFixture(): void
    {
        $minimalPopulatedAddress = $this->factory->create(
            houseNumber: '72',
            street: 'Playground Avenue',
            townCity: 'Macclesfield',
            postcode: 'SK57NT',
            country: 'GBR',
        );

        $this->repository->save($minimalPopulatedAddress);
    }
}
