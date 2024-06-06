<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator\Constraint;

use App\Validator\Constraint\Slug;
use App\Validator\Constraint\SlugValidator;
use PHPUnit\Framework\Attributes\TestWith;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class SlugValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new SlugValidator();
    }

    public function testWithInvalidConstraint(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate('lanentech', new NotBlank());
    }

    #[TestWith([''])]
    #[TestWith([null])]
    public function testValueIsValidAsConstraintLetsOthersConstraintDealWithThisValue(?string $value): void
    {
        $this->validator->validate($value, new Slug());

        $this->assertNoViolation();
    }

    public function testValueProvidedIsInvalid(): void
    {
        $this->validator->validate('l@n!nt<<|-|', new Slug());

        $this->buildViolation('Value provided is not a valid Slug')
            ->assertRaised();
    }

    public function testValueProvidedIsValid(): void
    {
        $this->validator->validate('lanentech-business-ident', new Slug());

        $this->assertNoViolation();
    }
}
