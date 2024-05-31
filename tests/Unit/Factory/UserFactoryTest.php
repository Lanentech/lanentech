<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Tests\TestCase\UnitTestCase;
use Carbon\Carbon;
use Mockery as m;
use PHPUnit\Framework\Attributes\TestWith;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactoryTest extends UnitTestCase
{
    private m\MockInterface|UserPasswordHasherInterface $passwordHasher;

    private UserFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->passwordHasher = m::mock(UserPasswordHasherInterface::class);

        $this->sut = new UserFactory(
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
}
