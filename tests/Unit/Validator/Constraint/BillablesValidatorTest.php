<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator\Constraint;

use App\Entity\Address;
use App\Entity\Billable;
use App\Validator\Constraint\Billables;
use App\Validator\Constraint\BillablesValidator;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class BillablesValidatorTest extends ConstraintValidatorTestCase
{
    private function getDummyBillable(): Billable
    {
        return (new Billable());
    }

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new BillablesValidator();
    }

    public function testWithInvalidConstraint(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(new ArrayCollection([$this->getDummyBillable()]), new NotBlank());
    }

    public function testWhenValueProvidedIsNotAnArrayCollection(): void
    {
        $this->validator->validate([$this->getDummyBillable()], new Billables());

        $this->buildViolation('Invalid value. Must be a Collection of "' . Billable::class . '" objects')
            ->assertRaised();
    }

    public function testValueProvidedIsNotValidBillableObject(): void
    {
        $this->validator->validate(new ArrayCollection([new Address()]), new Billables());

        $this->buildViolation('Invalid value. Must be a Collection of "' . Billable::class . '" objects')
            ->assertRaised();
    }

    public function testValueProvidedIsValid(): void
    {
        $this->validator->validate(new ArrayCollection([$this->getDummyBillable()]), new Billables());

        $this->assertNoViolation();
    }
}
