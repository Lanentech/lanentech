<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Director;
use App\Factory\LanentechFactoryInterface;
use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use LogicException;

class LanentechFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function __construct(
        private readonly LanentechFactoryInterface $lanentechFactory,
    ) {
    }

    public static function getGroups(): array
    {
        return ['application-fixture'];
    }

    public function load(ObjectManager $manager): void
    {
        if (!$incorporationDate = CarbonImmutable::create(year: 2023, month: 2, day: 13, hour: 9)) {
            throw new LogicException(
                sprintf(
                    'Could not create instance of %s for Incorporation date, null return from %s',
                    CarbonImmutable::class,
                    'CarbonImmutable::create',
                ),
            );
        }

        $lanentech = $this->lanentechFactory->create(
            name: 'Lanentech',
            companyNumber: 14657967,
            incorporationDate: $incorporationDate,
            directors: new ArrayCollection([
                $this->getReference(DirectorFixtures::FULLY_POPULATED_DIRECTOR, Director::class),
                $this->getReference(DirectorFixtures::MINIMALLY_POPULATED_DIRECTOR, Director::class),
            ]),
        );

        $manager->persist($lanentech);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            DirectorFixtures::class,
        ];
    }
}
