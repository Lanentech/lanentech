<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Repository\Traits\CanPersistAndFlushInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface UserRepositoryInterface extends PasswordUpgraderInterface, CanPersistAndFlushInterface
{
    /**
     * Creates a User object and hashes the password given. Does not persist or flush.
     *
     * @param string[] $roles
     */
    public function create(string $username, string $email, string $password, array $roles = []): User;

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void;
}
