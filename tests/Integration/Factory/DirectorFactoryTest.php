<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Exception\EntityFactoryValidationException;
use App\Factory\DirectorFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DirectorFactoryTest extends KernelTestCase
{
    private DirectorFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(DirectorFactoryInterface::class);
    }

    public function testOnCreateProducesValidationFailure(): void
    {
        $title = 'King';
        $firstName = '';
        $lastName = '';
        $email = str_repeat('invalid-email', 50);
        $mobileNumber = str_repeat('07427955632', 50);
        $dateOfBirth = '44/02/9999';
        $professionalTitle = str_repeat('Bsc Hons', 100);

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage('Title invalid. Must be one of');
        $this->expectExceptionMessage('Firstname cannot be empty');
        $this->expectExceptionMessage('Lastname cannot be empty');
        $this->expectExceptionMessage('Email cannot be more than 255 characters');
        $this->expectExceptionMessage('Email must be a valid email address');
        $this->expectExceptionMessage('Mobile cannot be more than 13 characters');
        $this->expectExceptionMessage('Date of Birth must be a valid date');
        $this->expectExceptionMessage('Professional Title cannot be more than 255 characters');
        $this->sut->create($firstName, $lastName, $title, $email, $mobileNumber, $dateOfBirth, $professionalTitle);
    }
}
