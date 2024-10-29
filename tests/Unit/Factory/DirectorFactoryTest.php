<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\Director;
use App\Exception\EntityFactoryValidationException;
use App\Factory\DirectorFactory;
use App\Tests\TestCase\UnitTestCase;
use Mockery as m;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DirectorFactoryTest extends UnitTestCase
{
    private m\MockInterface|ValidatorInterface $validator;

    private DirectorFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = m::mock(ValidatorInterface::class);

        $this->sut = new DirectorFactory(
            $this->validator,
        );
    }

    public function testCreate(): void
    {
        $title = 'Miss';
        $firstName = 'Teresa';
        $lastName = 'Green';
        $email = 'teresa.green@lanentech.co.uk';
        $mobileNumber = '07485266955';
        $dateOfBirth = '13/03/1992';
        $professionalTitle = 'Bsc Hons';

        $this->validator->expects('validate')->andReturn(new ConstraintViolationList());

        $result = $this->sut->create(
            $firstName,
            $lastName,
            $title,
            $email,
            $mobileNumber,
            $dateOfBirth,
            $professionalTitle,
        );

        $this->assertInstanceOf(Director::class, $result);
        $this->assertEquals($title, $result->getTitle());
        $this->assertEquals($firstName, $result->getFirstName());
        $this->assertEquals($lastName, $result->getLastName());
        $this->assertEquals($email, $result->getEmail());
        $this->assertEquals($mobileNumber, $result->getMobile());
        $this->assertEquals($dateOfBirth, $result->getDateOfBirth());
        $this->assertEquals($professionalTitle, $result->getProfessionalTitle());
    }

    public function testCreateFailsValidationChecks(): void
    {
        $title = 'Miss';
        $firstName = '';
        $lastName = 'Green';
        $email = 'teresa.green@lanentech.co.uk';
        $mobileNumber = '07485266955';
        $dateOfBirth = '13/03/1992';
        $professionalTitle = 'Bsc Hons';

        $violation = m::mock(ConstraintViolation::class);
        $violation->shouldReceive()->getMessage()->andReturn('Firstname cannot be empty');

        $violations = new ConstraintViolationList();
        $violations->add($violation);

        $this->validator->expects('validate')
            ->andThrows(new EntityFactoryValidationException(m::capture($director), $violations));

        $this->expectException(EntityFactoryValidationException::class);
        $this->sut->create(
            $firstName,
            $lastName,
            $title,
            $email,
            $mobileNumber,
            $dateOfBirth,
            $professionalTitle,
        );
    }
}
