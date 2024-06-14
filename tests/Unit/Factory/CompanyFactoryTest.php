<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\Address;
use App\Entity\Company;
use App\Entity\Const\Company as CompanyConstants;
use App\Exception\EntityFactoryValidationException;
use App\Factory\CompanyFactory;
use App\Tests\TestCase\UnitTestCase;
use Mockery as m;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CompanyFactoryTest extends UnitTestCase
{
    private m\MockInterface|ValidatorInterface $validator;

    private CompanyFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = m::mock(ValidatorInterface::class);

        $this->sut = new CompanyFactory(
            $this->validator,
        );
    }

    public function testCreate(): void
    {
        $name = 'Lanentech';
        $ident = 'lanentech';
        $type = CompanyConstants::TYPE_BUSINESS;
        $companyNumber = 12345678;
        $address = (new Address())
            ->setHouseNumber('3')
            ->setStreet('Tarkov Street')
            ->setTownCity('Liverpool')
            ->setPostcode('LV1 0OL')
            ->setCountry('GBR');

        $this->validator->expects('validate')->andReturn(new ConstraintViolationList());

        $result = $this->sut->create($name, $ident, $type, $companyNumber, $address);

        $this->assertInstanceOf(Company::class, $result);
        $this->assertEquals($name, $result->getName());
        $this->assertEquals($ident, $result->getIdent());
        $this->assertEquals($type, $result->getType());
        $this->assertEquals($companyNumber, $result->getCompanyNumber());
        $this->assertEquals($address, $result->getAddress());
    }

    public function testCreateFailsValidationChecks(): void
    {
        $name = '';
        $ident = 'lanentech';
        $type = CompanyConstants::TYPE_BUSINESS;
        $companyNumber = 12345678;
        $address = (new Address())
            ->setHouseNumber('3')
            ->setStreet('Tarkov Street')
            ->setTownCity('Liverpool')
            ->setPostcode('LV1 0OL')
            ->setCountry('GBR');

        $violation = m::mock(ConstraintViolation::class);
        $violation->expects()->getMessage()->andReturn('Name cannot be empty');

        $violations = new ConstraintViolationList();
        $violations->add($violation);

        $this->validator->expects('validate')
            ->andThrows(new EntityFactoryValidationException(m::capture($company), $violations));

        $this->expectException(EntityFactoryValidationException::class);
        $this->sut->create($name, $ident, $type, $companyNumber, $address);
    }
}
