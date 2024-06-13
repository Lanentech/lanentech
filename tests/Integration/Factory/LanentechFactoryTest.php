<?php

declare(strict_types=1);

namespace App\Tests\Integration\Factory;

use App\Entity\Address;
use App\Entity\Director;
use App\Exception\EntityFactoryValidationException;
use App\Factory\LanentechFactoryInterface;
use App\Tests\TestCase\IntegrationTestCase;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;

class LanentechFactoryTest extends IntegrationTestCase
{
    private LanentechFactoryInterface $sut;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->sut = self::getContainer()->get(LanentechFactoryInterface::class);
    }

    public function testOnCreateProducesPreValidationFailure(): void
    {
        $name = 'Lanentech';
        $companyNumber = 12345678;
        $incorporationDate = CarbonImmutable::parse('2023-02-23');
        $directors = new ArrayCollection([
            new Address(),
        ]);

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage(
            'Invalid "directors" value. Must be a Collection of "App\Entity\Director" objects',
        );
        $this->sut->create($name, $companyNumber, $incorporationDate, $directors);
    }

    public function testOnCreateProducesObjectValidationFailure(): void
    {
        $name = '';
        $companyNumber = 123456789123456789;
        $incorporationDate = CarbonImmutable::parse('2023-02-23');
        $directors = new ArrayCollection([
            (new Director())
                ->setTitle('Miss')
                ->setFirstName('Teresa')
                ->setLastName('Green')
                ->setEmail('teresa.green@lanentech.co.uk')
                ->setMobile('07485266955')
                ->setDateOfBirth('13/03/1992')
                ->setProfessionalTitle('Bsc Hons'),
        ]);

        $this->expectException(EntityFactoryValidationException::class);
        $this->expectExceptionMessage('Name cannot be empty');
        $this->expectExceptionMessage('Company Number cannot be more than 8 digits');
        $this->sut->create($name, $companyNumber, $incorporationDate, $directors);
    }
}
