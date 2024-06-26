<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Entity\Const\Director as DirectorConstants;
use App\Exception\EntityFactoryValidationException;
use App\Factory\DirectorFactoryInterface;
use App\Tests\TestCase\IntegrationTestCase;

class DirectorFactoryTest extends IntegrationTestCase
{
    private DirectorFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(DirectorFactoryInterface::class);
    }

    public function testOnCreateProducesObjectValidationFailure(): void
    {
        $title = 'King';
        $firstName = '';
        $lastName = '';
        $email = str_repeat('invalid-email', 50);
        $mobileNumber = str_repeat('07427955632', 50);
        $dateOfBirth = '44/02/9999';
        $professionalTitle = str_repeat('Bsc Hons', 100);

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage(
            sprintf('Type invalid. Must be one of: %s', implode(',', DirectorConstants::TITLES)),
        );
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
