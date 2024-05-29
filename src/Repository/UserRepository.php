<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Repository\Traits\CanPersistAndFlush;
use Carbon\CarbonImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    use CanPersistAndFlush;

    public function __construct(
        ManagerRegistry $registry,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct($registry, User::class);
    }

    public function create(string $name, string $username, string $email, string $password, array $roles = []): User
    {
        $user = new User();

        $user->setName($name);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $now = new CarbonImmutable();
        $user->setCreatedAt($now);
        $user->setUpdatedAt($now);

        if (!empty($roles)) {
            $user->setRoles($roles);
        }

        return $user;
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);

        $this->persist($user);
        $this->flush();
    }
}
