<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\Director;
use App\Entity\Lanentech;
use App\Exception\EntityFactoryValidationException;
use App\Factory\LanentechFactory;
use App\Tests\TestCase\UnitTestCase;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Mockery as m;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LanentechFactoryTest extends UnitTestCase
{
    private m\MockInterface|ValidatorInterface $validator;

    private LanentechFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = m::mock(ValidatorInterface::class);

        $this->sut = new LanentechFactory(
            $this->validator,
        );
    }

    public function testCreate(): void
    {
        $name = 'Lanentech';
        $companyNumber = 12345678;
        $incorporationDate = CarbonImmutable::parse('2023-02-23');
        $directors = new ArrayCollection([
            (new Director())
                ->setTitle('Miss')
                ->setFirstName('Teresa')
                ->setLastName('Green')
                ->setEmail('teresa.green@lanentech.co.uk')
                ->setMobile('07485266955')
                ->setDateOfBirth('13/03/1992')
                ->setProfessionalTitle('Bsc Hons'),
        ]);

        $this->validator->expects('validate')->twice()->andReturn(new ConstraintViolationList());

        $result = $this->sut->create($name, $companyNumber, $incorporationDate, $directors);

        $this->assertInstanceOf(Lanentech::class, $result);
        $this->assertEquals($name, $result->getName());
        $this->assertEquals($companyNumber, $result->getCompanyNumber());
        $this->assertEquals($incorporationDate, $result->getIncorporationDate());
        $this->assertEquals($directors, $result->getDirectors());
    }

    public function testCreateFailsValidationChecks(): void
    {
        $name = '';
        $companyNumber = 12345678;
        $incorporationDate = CarbonImmutable::parse('2023-02-23');
        $directors = new ArrayCollection([
            (new Director())
                ->setTitle('Miss')
                ->setFirstName('Teresa')
                ->setLastName('Green')
                ->setEmail('teresa.green@lanentech.co.uk')
                ->setMobile('07485266955')
                ->setDateOfBirth('13/03/1992')
                ->setProfessionalTitle('Bsc Hons'),
        ]);

        $violation = m::mock(ConstraintViolation::class);
        $violation->shouldReceive()->getMessage()->andReturn('Name cannot be empty');

        $violations = new ConstraintViolationList();
        $violations->add($violation);

        $this->validator->expects('validate')
            ->andThrows(new EntityFactoryValidationException(m::capture($lanentech), $violations));

        $this->expectException(EntityFactoryValidationException::class);
        $this->sut->create($name, $companyNumber, $incorporationDate, $directors);
    }
}
