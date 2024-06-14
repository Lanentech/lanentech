<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Entity\Address;
use App\Entity\Const\Company as CompanyConstants;
use App\Exception\EntityFactoryValidationException;
use App\Factory\CompanyFactoryInterface;
use App\Tests\TestCase\IntegrationTestCase;

class CompanyFactoryTest extends IntegrationTestCase
{
    private CompanyFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(CompanyFactoryInterface::class);
    }

    public function testOnCreateProducesObjectValidationFailure(): void
    {
        $name = '';
        $ident = str_repeat('lanentech', 200);
        $type = 'Toy Shop';
        $companyNumber = 123456789;
        $address = (new Address())
            ->setHouseNumber('3')
            ->setStreet('Tarkov Street')
            ->setTownCity('Liverpool')
            ->setPostcode('LV1 0OL')
            ->setCountry('GBR');

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage('Name cannot be empty');
        $this->expectExceptionMessage('Ident cannot be more than 255 characters');
        $this->expectExceptionMessage(
            sprintf('Type invalid. Must be one of: %s', implode(',', CompanyConstants::TYPES)),
        );
        $this->expectExceptionMessage('Company Number cannot be more than 8 digits');
        $this->sut->create($name, $ident, $type, $companyNumber, $address);
    }
}
