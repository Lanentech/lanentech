<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Director;
use App\Factory\DirectorFactoryInterface;
use App\Repository\DirectorRepositoryInterface;
use Doctrine\Persistence\ObjectManager;

class DirectorFixtures extends AbstractFixture
{
    public const string FULLY_POPULATED_DIRECTOR = 'fully_populated_director';
    public const string MINIMALLY_POPULATED_DIRECTOR = 'minimally_populated_director';

    public function __construct(
        private readonly DirectorFactoryInterface $factory,
        private readonly DirectorRepositoryInterface $repository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullyPopulatedDirectorFixture();
        $this->createMinimallyPopulatedDirectorFixture();
    }

    private function createFullyPopulatedDirectorFixture(): void
    {
        $fullyPopulatedDirector = $this->factory->create(
            firstName: 'Teresa',
            lastName: 'Green',
            title: 'Miss',
            email: 'teresa.green@lanentech.co.uk',
            mobile: '07427615948',
            dateOfBirth: '25/07/1992',
            professionalTitle: 'Bsc Hons',
        );

        $this->repository->save($fullyPopulatedDirector);

        if (!$this->hasReference(self::FULLY_POPULATED_DIRECTOR, Director::class)) {
            $this->addReference(self::FULLY_POPULATED_DIRECTOR, $fullyPopulatedDirector);
        }
    }

    private function createMinimallyPopulatedDirectorFixture(): void
    {
        $minimallyPopulatedDirector = $this->factory->create(
            firstName: 'Joe',
            lastName: 'Bloggs',
        );

        $this->repository->save($minimallyPopulatedDirector);

        if (!$this->hasReference(self::MINIMALLY_POPULATED_DIRECTOR, Director::class)) {
            $this->addReference(self::MINIMALLY_POPULATED_DIRECTOR, $minimallyPopulatedDirector);
        }
    }
}
