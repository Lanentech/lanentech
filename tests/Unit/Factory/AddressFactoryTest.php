<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\Address;
use App\Exception\EntityFactoryValidationException;
use App\Factory\AddressFactory;
use App\Tests\TestCase\UnitTestCase;
use Mockery as m;
use Mockery\MockInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressFactoryTest extends UnitTestCase
{
    private MockInterface|ValidatorInterface $validator;

    private AddressFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = m::mock(ValidatorInterface::class);

        $this->sut = new AddressFactory(
            $this->validator,
        );
    }

    public function testCreate(): void
    {
        $houseNumber = '723a';
        $street = 'Sycamore Avenue';
        $townCity = 'Addely-upon-avon';
        $postcode = 'CA16 6FT';
        $country = 'GBR';
        $houseName = 'Farmendale';

        $this->validator->expects('validate')->andReturn(new ConstraintViolationList());

        $result = $this->sut->create($houseNumber, $street, $townCity, $postcode, $country, $houseName);

        $this->assertInstanceOf(Address::class, $result);
        $this->assertEquals($houseName, $result->getHouseName());
        $this->assertEquals($houseNumber, $result->getHouseNumber());
        $this->assertEquals($street, $result->getStreet());
        $this->assertEquals($townCity, $result->getTownCity());
        $this->assertEquals($postcode, $result->getPostcode());
        $this->assertEquals($country, $result->getCountry());
    }

    public function testCreateFailsValidationChecks(): void
    {
        $houseNumber = '723a';
        $street = '';
        $townCity = 'Addely-upon-avon';
        $postcode = 'CA16 6FT';
        $country = 'GBR';
        $houseName = 'Farmendale';

        $violation = m::mock(ConstraintViolation::class);
        $violation->expects()->getMessage()->andReturn('Street cannot be empty');

        $violations = new ConstraintViolationList();
        $violations->add($violation);

        $this->validator->expects('validate')
            ->andThrows(new EntityFactoryValidationException(m::capture($address), $violations));

        $this->expectException(EntityFactoryValidationException::class);
        $this->sut->create($houseNumber, $street, $townCity, $postcode, $country, $houseName);
    }
}
