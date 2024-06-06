<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Const\Company as CompanyConstants;
use App\Factory\CompanyFactoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly CompanyFactoryInterface $companyFactory,
    ) {
    }

    public static function getGroups(): array
    {
        return ['application-fixture'];
    }

    public function load(ObjectManager $manager): void
    {
        $fullyPopulatedCompany = $this->companyFactory->create(
            name: 'Lanentech',
            ident: 'lanentech',
            type: CompanyConstants::TYPE_BUSINESS,
            companyNumber: 14657967,
            address: (new Address())
                ->setHouseNumber('650')
                ->setStreet('Anlaby Road')
                ->setTownCity('Kingston Upon Hull')
                ->setPostcode('HU3 6UU')
                ->setCountry('GBR')
        );
        $manager->persist($fullyPopulatedCompany);

        $fullyPopulatedAgency = $this->companyFactory->create(
            name: 'Agents R Us',
            ident: 'agents-r-us',
            type: CompanyConstants::TYPE_AGENCY,
            companyNumber: 78912365,
            address: (new Address())
                ->setHouseNumber('23a')
                ->setStreet('Podrick Avenue')
                ->setTownCity('Chester')
                ->setPostcode('C12 4KM')
                ->setCountry('GBR')
        );
        $manager->persist($fullyPopulatedAgency);

        $agencyWithNoAddress = $this->companyFactory->create(
            name: 'Morpheus International',
            ident: 'morpheus-international',
            type: CompanyConstants::TYPE_AGENCY,
            companyNumber: 12345678,
        );
        $manager->persist($agencyWithNoAddress);

        $fullyPopulatedClient = $this->companyFactory->create(
            name: 'Elite Tech UK',
            ident: 'elite-tech-uk',
            type: CompanyConstants::TYPE_CLIENT,
            companyNumber: 66648598,
            address: (new Address())
                ->setHouseNumber('84')
                ->setStreet('Terrance Lane')
                ->setTownCity('Manchester')
                ->setPostcode('M17 9BH')
                ->setCountry('GBR')
        );
        $manager->persist($fullyPopulatedClient);

        $clientWithNoAddress = $this->companyFactory->create(
            name: 'Wired Technologies',
            ident: 'wired-technologies',
            type: CompanyConstants::TYPE_CLIENT,
            companyNumber: 78945612,
        );
        $manager->persist($clientWithNoAddress);

        $manager->flush();
    }
}
