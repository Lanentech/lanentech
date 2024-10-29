<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Company;
use App\Entity\Const\Company as CompanyConstants;
use App\Factory\CompanyFactoryInterface;
use App\Repository\CompanyRepositoryInterface;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends AbstractFixture
{
    public const string AGENCY_WITH_NO_ADDRESS = 'agency_with_no_address';
    public const string CLIENT_WITH_NO_ADDRESS = 'client_with_no_address';
    public const string FULLY_POPULATED_AGENCY = 'fully_populated_agency';
    public const string FULLY_POPULATED_CLIENT = 'fully_populated_client';
    public const string FULLY_POPULATED_COMPANY = 'fully_populated_company';

    public function __construct(
        private readonly CompanyFactoryInterface $factory,
        private readonly CompanyRepositoryInterface $repository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullyPopulatedCompanyFixture();
        $this->createFullyPopulatedAgencyFixture();
        $this->createCompanyWithNoAddressFixture();
        $this->createFullyPopulatedClientFixture();
        $this->createClientWithNoAddressFixture();
    }

    private function createFullyPopulatedCompanyFixture(): void
    {
        $fullyPopulatedCompany = $this->factory->create(
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

        $this->repository->save($fullyPopulatedCompany);

        if (!$this->hasReference(self::FULLY_POPULATED_COMPANY, Company::class)) {
            $this->addReference(self::FULLY_POPULATED_COMPANY, $fullyPopulatedCompany);
        }
    }

    private function createFullyPopulatedAgencyFixture(): void
    {
        $fullyPopulatedAgency = $this->factory->create(
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

        $this->repository->save($fullyPopulatedAgency);

        if (!$this->hasReference(self::FULLY_POPULATED_AGENCY, Company::class)) {
            $this->addReference(self::FULLY_POPULATED_AGENCY, $fullyPopulatedAgency);
        }
    }

    private function createCompanyWithNoAddressFixture(): void
    {
        $agencyWithNoAddress = $this->factory->create(
            name: 'Morpheus International',
            ident: 'morpheus-international',
            type: CompanyConstants::TYPE_AGENCY,
            companyNumber: 12345678,
        );

        $this->repository->save($agencyWithNoAddress);

        if (!$this->hasReference(self::AGENCY_WITH_NO_ADDRESS, Company::class)) {
            $this->addReference(self::AGENCY_WITH_NO_ADDRESS, $agencyWithNoAddress);
        }
    }

    private function createFullyPopulatedClientFixture(): void
    {
        $fullyPopulatedClient = $this->factory->create(
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

        $this->repository->save($fullyPopulatedClient);

        if (!$this->hasReference(self::FULLY_POPULATED_CLIENT, Company::class)) {
            $this->addReference(self::FULLY_POPULATED_CLIENT, $fullyPopulatedClient);
        }
    }

    private function createClientWithNoAddressFixture(): void
    {
        $clientWithNoAddress = $this->factory->create(
            name: 'Wired Technologies',
            ident: 'wired-technologies',
            type: CompanyConstants::TYPE_CLIENT,
            companyNumber: 78945612,
        );

        $this->repository->save($clientWithNoAddress);

        if (!$this->hasReference(self::CLIENT_WITH_NO_ADDRESS, Company::class)) {
            $this->addReference(self::CLIENT_WITH_NO_ADDRESS, $clientWithNoAddress);
        }
    }
}
