<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\UserFactoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly UserFactoryInterface $userFactory,
    ) {
    }

    public static function getGroups(): array
    {
        return ['application-fixture'];
    }

    public function load(ObjectManager $manager): void
    {
        $standardUser = $this->userFactory->create(
            name: 'Standard User',
            username: 'standard-user',
            email: 'standard-user@lanentech.co.uk',
            password: 'password',
        );
        $manager->persist($standardUser);

        $adminUser = $this->userFactory->create(
            name: 'Admin User',
            username: 'admin-user',
            email: 'admin-user@lanentech.co.uk',
            password: 'password',
        );
        $manager->persist($adminUser);

        $manager->flush();
    }
}
