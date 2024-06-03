<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator\Constraint;

use App\Validator\Constraint\DateOfBirth;
use App\Validator\Constraint\DateOfBirthValidator;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\TestWith;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class DateOfBirthValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new DateOfBirthValidator();
    }

    public function testWithInvalidConstraint(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate('25/08/1992', new NotBlank());
    }

    #[TestWith([''])]
    #[TestWith([null])]
    public function testValueIsValidAsConstraintLetsOthersConstraintDealWithThisValue(?string $value): void
    {
        $this->validator->validate($value, new DateOfBirth());

        $this->assertNoViolation();
    }

    public function testValueProvidedIsInvalidAsDayValueIsIncorrect(): void
    {
        $this->validator->validate('44/01/1992', new DateOfBirth());

        $this->buildViolation('Value provided is not a valid Date of Birth')
            ->assertRaised();
    }

    public function testValueProvidedIsInvalidAsIsAFutureDate(): void
    {
        $dateOneYearAhead = sprintf('25/08/%s', (Carbon::now())->addYear()->year);

        $this->validator->validate($dateOneYearAhead, new DateOfBirth());

        $this->buildViolation('Value provided is not a valid Date of Birth')
            ->assertRaised();
    }

    public function testValueProvidedIsValid(): void
    {
        $this->validator->validate('25/08/1992', new DateOfBirth());

        $this->assertNoViolation();
    }
}
