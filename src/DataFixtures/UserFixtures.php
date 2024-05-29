<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Repository\UserRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $standardUser = $this->userRepository->create(
            name: 'Standard User',
            username: 'standard-user',
            email: 'standard-user@lanentech.co.uk',
            password: 'password',
        );
        $manager->persist($standardUser);

        $adminUser = $this->userRepository->create(
            name: 'Admin User',
            username: 'admin-user',
            email: 'admin-user@lanentech.co.uk',
            password: 'password',
        );
        $manager->persist($adminUser);

        $manager->flush();
    }
}
