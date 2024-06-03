<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Exception\EntityFactoryValidationException;
use App\Factory\AddressFactoryInterface;
use App\Tests\TestCase\IntegrationTestCase;

class AddressFactoryTest extends IntegrationTestCase
{
    private AddressFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(AddressFactoryInterface::class);
    }

    public function testOnCreateProducesValidationFailure(): void
    {
        $houseNumber = '123456789123';
        $street = '';
        $townCity = str_repeat('Street', 25);
        $postcode = '123 456';
        $country = 'GB';
        $houseName = str_repeat('House Name', 25);

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage('House Name cannot be more than 50 characters');
        $this->expectExceptionMessage('House Number cannot be more than 10 characters');
        $this->expectExceptionMessage('Street cannot be empty');
        $this->expectExceptionMessage('Town/City cannot be more than 75 characters');
        $this->expectExceptionMessage('Postcode must be valid');
        $this->expectExceptionMessage('Country but be a 3 letter ISO code');
        $this->sut->create($houseNumber, $street, $townCity, $postcode, $country, $houseName);
    }
}
