<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

readonly class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function findOneById(int $id): ?User
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('user')
            ->from(User::class, 'user')
            ->where('user.id = :id')
            ->setParameter('id', $id);

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result) && count($result) > 0) {
            if ($result[0] instanceof User) {
                return $result[0];
            }
        }

        return null;
    }

    public function findOneByEmail(string $email): ?User
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('user')
            ->from(User::class, 'user')
            ->where('user.email = :email')
            ->setParameter('email', $email);

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result) && count($result) > 0) {
            if ($result[0] instanceof User) {
                return $result[0];
            }
        }

        return null;
    }

    public function findOneByUsername(string $username): ?User
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('user')
            ->from(User::class, 'user')
            ->where('user.username = :username')
            ->setParameter('username', $username);

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result) && count($result) > 0) {
            if ($result[0] instanceof User) {
                return $result[0];
            }
        }

        return null;
    }

    public function findAll(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('user')
            ->from(User::class, 'user');

        $result = $queryBuilder->getQuery()->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof User);
        }

        return [];
    }

    public function fetchBatch(int $offset, int $limit): array
    {
        $result = $this->entityManager->createQueryBuilder()
            ->select('user')
            ->from(User::class, 'user')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        if (is_array($result)) {
            return array_filter($result, static fn ($item) => $item instanceof User);
        }

        return [];
    }

    public function delete(User $object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }

    public function save(?User $object = null): void
    {
        if ($object && $object->getId() === null) {
            $this->entityManager->persist($object);
        }

        $this->entityManager->flush();
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user);
    }
}
