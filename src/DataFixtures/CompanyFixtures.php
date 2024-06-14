<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Company;
use App\Entity\Const\Company as CompanyConstants;
use App\Factory\CompanyFactoryInterface;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends AbstractFixture
{
    public const string AGENCY_WITH_NO_ADDRESS = 'agency_with_no_address';
    public const string CLIENT_WITH_NO_ADDRESS = 'client_with_no_address';
    public const string FULLY_POPULATED_AGENCY = 'fully_populated_agency';
    public const string FULLY_POPULATED_CLIENT = 'fully_populated_client';
    public const string FULLY_POPULATED_COMPANY = 'fully_populated_company';

    public function __construct(
        private readonly CompanyFactoryInterface $companyFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullyPopulatedCompanyFixture($manager);
        $this->createFullyPopulatedAgencyFixture($manager);
        $this->createCompanyWithNoAddressFixture($manager);
        $this->createFullyPopulatedClientFixture($manager);
        $this->createClientWithNoAddressFixture($manager);

        $manager->flush();
    }

    private function createFullyPopulatedCompanyFixture(ObjectManager $manager): void
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

        if (!$this->hasReference(self::FULLY_POPULATED_COMPANY, Company::class)) {
            $this->addReference(self::FULLY_POPULATED_COMPANY, $fullyPopulatedCompany);
        }
    }

    private function createFullyPopulatedAgencyFixture(ObjectManager $manager): void
    {
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

        if (!$this->hasReference(self::FULLY_POPULATED_AGENCY, Company::class)) {
            $this->addReference(self::FULLY_POPULATED_AGENCY, $fullyPopulatedAgency);
        }
    }

    private function createCompanyWithNoAddressFixture(ObjectManager $manager): void
    {
        $agencyWithNoAddress = $this->companyFactory->create(
            name: 'Morpheus International',
            ident: 'morpheus-international',
            type: CompanyConstants::TYPE_AGENCY,
            companyNumber: 12345678,
        );

        $manager->persist($agencyWithNoAddress);

        if (!$this->hasReference(self::AGENCY_WITH_NO_ADDRESS, Company::class)) {
            $this->addReference(self::AGENCY_WITH_NO_ADDRESS, $agencyWithNoAddress);
        }
    }

    private function createFullyPopulatedClientFixture(ObjectManager $manager): void
    {
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

        if (!$this->hasReference(self::FULLY_POPULATED_CLIENT, Company::class)) {
            $this->addReference(self::FULLY_POPULATED_CLIENT, $fullyPopulatedClient);
        }
    }

    private function createClientWithNoAddressFixture(ObjectManager $manager): void
    {
        $clientWithNoAddress = $this->companyFactory->create(
            name: 'Wired Technologies',
            ident: 'wired-technologies',
            type: CompanyConstants::TYPE_CLIENT,
            companyNumber: 78945612,
        );

        $manager->persist($clientWithNoAddress);

        if (!$this->hasReference(self::CLIENT_WITH_NO_ADDRESS, Company::class)) {
            $this->addReference(self::CLIENT_WITH_NO_ADDRESS, $clientWithNoAddress);
        }
    }
}
