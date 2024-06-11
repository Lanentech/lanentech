<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\DirectorFactoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class DirectorFixtures extends Fixture implements FixtureGroupInterface
{
    public const string FULLY_POPULATED_DIRECTOR = 'fully_populated_director';
    public const string MINIMALLY_POPULATED_DIRECTOR = 'minimally_populated_director';

    public function __construct(
        private readonly DirectorFactoryInterface $directorFactory,
    ) {
    }

    public static function getGroups(): array
    {
        return ['application-fixture'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->addFullyPopulatedDirectorFixture($manager);
        $this->addMinimallyPopulatedDirectorFixture($manager);

        $manager->flush();
    }

    private function addFullyPopulatedDirectorFixture(ObjectManager $manager): void
    {
        $fullyPopulatedDirector = $this->directorFactory->create(
            firstName: 'Teresa',
            lastName: 'Green',
            title: 'Miss',
            email: 'teresa.green@lanentech.co.uk',
            mobile: '07427615948',
            dateOfBirth: '25/07/1992',
            professionalTitle: 'Bsc Hons',
        );

        $manager->persist($fullyPopulatedDirector);

        $this->addReference(self::FULLY_POPULATED_DIRECTOR, $fullyPopulatedDirector);
    }

    private function addMinimallyPopulatedDirectorFixture(ObjectManager $manager): void
    {
        $minimallyPopulatedDirector = $this->directorFactory->create(
            firstName: 'Joe',
            lastName: 'Bloggs',
        );

        $manager->persist($minimallyPopulatedDirector);

        $this->addReference(self::MINIMALLY_POPULATED_DIRECTOR, $minimallyPopulatedDirector);
    }
}
