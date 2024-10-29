<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\User;
use App\Exception\EntityFactoryValidationException;
use App\Factory\UserFactory;
use App\Tests\TestCase\UnitTestCase;
use Carbon\Carbon;
use Mockery as m;
use PHPUnit\Framework\Attributes\TestWith;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactoryTest extends UnitTestCase
{
    private m\MockInterface|UserPasswordHasherInterface $passwordHasher;
    private m\MockInterface|ValidatorInterface $validator;

    private UserFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->passwordHasher = m::mock(UserPasswordHasherInterface::class);
        $this->validator = m::mock(ValidatorInterface::class);

        $this->sut = new UserFactory(
            $this->validator,
            $this->passwordHasher,
        );
    }

    #[TestWith([[]])]
    #[TestWith([['ROLE_ADMIN']])]
    public function testCreate(array $roles): void
    {
        $now = Carbon::create(2024, 1, 1, 1, 1, 1);
        Carbon::setTestNow($now);

        $name = 'Standard User';
        $username = 'standard-user';
        $email = 'standard-user@lanentech.co.uk';
        $password = 'password';

        $this->passwordHasher->expects('hashPassword')
            ->with(m::capture($user), $password)
            ->andReturn($hash = 'qwerty123456');

        $this->validator->expects('validate')->andReturn(new ConstraintViolationList());

        $result = $this->sut->create($name, $username, $email, $password, $roles);

        $expectedRoles = array_filter(array_merge(['ROLE_USER'], $roles));
        sort($expectedRoles);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($name, $result->getName());
        $this->assertEquals($username, $result->getUsername());
        $this->assertEquals($username, $result->getUserIdentifier());
        $this->assertEquals($email, $result->getEmail());
        $this->assertEquals($hash, $result->getPassword());
        $this->assertEquals($now, $result->getCreatedAt());
        $this->assertEquals($now, $result->getUpdatedAt());
        $this->assertEquals($expectedRoles, $result->getRoles());
        $this->assertNull($result->getLastLoggedIn());
    }

    public function testCreateFailsValidationChecks(): void
    {
        $now = Carbon::create(2024, 1, 1, 1, 1, 1);
        Carbon::setTestNow($now);

        $username = 'standard-user';
        $email = 'standard-user@lanentech.co.uk';
        $password = 'password';

        $this->passwordHasher->expects('hashPassword')
            ->with(m::capture($user), $password)
            ->andReturn('qwerty123456');

        $violation = m::mock(ConstraintViolation::class);
        $violation->shouldReceive()->getMessage()->andReturn('Username cannot be empty');

        $violations = new ConstraintViolationList();
        $violations->add($violation);

        $this->validator->expects('validate')
            ->andThrows(new EntityFactoryValidationException(m::capture($user), $violations));

        $this->expectException(EntityFactoryValidationException::class);
        $this->sut->create('', $username, $email, $password);
    }
}
