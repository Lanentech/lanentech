<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator\Constraint;

use App\Entity\Address;
use App\Entity\Director;
use App\Validator\Constraint\LanentechDirectors;
use App\Validator\Constraint\LanentechDirectorsValidator;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class LanentechDirectorsValidatorTest extends ConstraintValidatorTestCase
{
    private function getDummyDirector(): Director
    {
        return (new Director())
            ->setTitle('Miss')
            ->setFirstName('Teresa')
            ->setLastName('Green')
            ->setEmail('teresa.green@lanentech.co.uk')
            ->setMobile('07485266955')
            ->setDateOfBirth('13/03/1992')
            ->setProfessionalTitle('Bsc Hons');
    }

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new LanentechDirectorsValidator();
    }

    public function testWithInvalidConstraint(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(new ArrayCollection([$this->getDummyDirector()]), new NotBlank());
    }

    public function testWhenValueProvidedIsNotAnArrayCollection(): void
    {
        $this->validator->validate([$this->getDummyDirector()], new LanentechDirectors());

        $this->buildViolation('Invalid "{{ key }}" value. Must be a Collection of "' . Director::class . '" objects')
            ->setParameter('{{ key }}', 'directors')
            ->assertRaised();
    }

    public function testValueProvidedIsNotValidDirectorObject(): void
    {
        $this->validator->validate(new ArrayCollection([new Address()]), new LanentechDirectors());

        $this->buildViolation('Invalid "{{ key }}" value. Must be a Collection of "' . Director::class . '" objects')
            ->setParameter('{{ key }}', 'directors')
            ->assertRaised();
    }

    public function testValueProvidedIsValid(): void
    {
        $this->validator->validate(new ArrayCollection([$this->getDummyDirector()]), new LanentechDirectors());

        $this->assertNoViolation();
    }
}
