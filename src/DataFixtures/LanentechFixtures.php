<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Director;
use App\Factory\LanentechFactoryInterface;
use App\Repository\LanentechRepositoryInterface;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LanentechFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly LanentechFactoryInterface $factory,
        private readonly LanentechRepositoryInterface $repository,
    ) {
    }

    public function getDependencies(): array
    {
        return [
            DirectorFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFullyPopulatedLanentechFixture();
    }

    private function createFullyPopulatedLanentechFixture(): void
    {
        if (!$incorporationDate = CarbonImmutable::create(year: 2023, month: 2, day: 13, hour: 9)) {
            $this->throwExceptionWhenDateCannotBeCreated('Incorporation Date');
        }

        $lanentech = $this->factory->create(
            name: 'Lanentech',
            companyNumber: 14657967,
            incorporationDate: $incorporationDate,
            directors: new ArrayCollection([
                $this->getReference(DirectorFixtures::FULLY_POPULATED_DIRECTOR, Director::class),
                $this->getReference(DirectorFixtures::MINIMALLY_POPULATED_DIRECTOR, Director::class),
            ]),
        );

        $this->repository->save($lanentech);
    }
}
