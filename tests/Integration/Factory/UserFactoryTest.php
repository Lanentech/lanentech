<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Exception\EntityFactoryValidationException;
use App\Factory\UserFactoryInterface;
use App\Tests\TestCase\IntegrationTestCase;

class UserFactoryTest extends IntegrationTestCase
{
    private UserFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(UserFactoryInterface::class);
    }

    public function testOnCreateProducesObjectValidationFailure(): void
    {
        $name = '';
        $username = str_repeat('standard-user', 50);
        $email = 'invalid-email';

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage('Name cannot be empty');
        $this->expectExceptionMessage('Username cannot be more than 180 characters');
        $this->expectExceptionMessage('Email must be a valid email address');
        $this->sut->create($name, $username, $email, 'password');
    }
}
