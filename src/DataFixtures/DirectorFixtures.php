<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\DirectorFactoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class DirectorFixtures extends Fixture implements FixtureGroupInterface
{
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
        $fullyPopulatedDirector = $this->directorFactory->create(
            firstName: 'Daniel',
            lastName: 'Griffiths',
            title: 'Mr',
            email: 'd.griffiths@lanentech.co.uk',
            mobile: '07427615948',
            dateOfBirth: '25/07/1992',
            professionalTitle: 'Bsc Hons',
        );
        $manager->persist($fullyPopulatedDirector);

        $minimallyPopulatedDirector = $this->directorFactory->create(
            firstName: 'Joe',
            lastName: 'Bloggs',
        );
        $manager->persist($minimallyPopulatedDirector);

        $manager->flush();
    }
}
