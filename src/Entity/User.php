<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\SetId;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    use SetId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[Assert\Length(max: 180, maxMessage: 'Name cannot be more than 180 characters')]
    #[Assert\NotBlank(message: 'Name cannot be empty')]
    #[Assert\Type('string', message: 'Name must be a string')]
    #[ORM\Column(length: 180)]
    private string $name;

    #[Assert\Length(max: 180, maxMessage: 'Username cannot be more than 180 characters')]
    #[Assert\NotBlank(message: 'Username cannot be empty')]
    #[Assert\Type('string', message: 'Username must be a string')]
    #[ORM\Column(length: 180, unique: true)]
    private string $username;

    /**
     * @var string[]
     */
    #[Assert\Type('array', message: 'Roles must be an array of strings')]
    #[ORM\Column]
    private array $roles = [];

    #[Assert\NotBlank(message: 'Password cannot be empty')]
    #[Assert\Type('string', message: 'Password must be a string')]
    #[ORM\Column]
    private string $password;

    #[Assert\Email(message: 'Email must be a valid email address')]
    #[Assert\Length(max: 255, maxMessage: 'Email cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Email cannot be empty')]
    #[Assert\Type('string', message: 'Email must be a string')]
    #[ORM\Column(length: 255)]
    private string $email;

    #[Assert\DateTime(message: 'createdAt must be a valid DateTime')]
    #[Assert\NotNull(message: 'createdAt cannot be null')]
    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(name: 'created_at', type: 'carbon_immutable', nullable: false)]
    private DateTimeImmutable $createdAt;

    #[Assert\DateTime(message: 'updatedAt must be a valid DateTime')]
    #[Assert\NotNull(message: 'updatedAt cannot be null')]
    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(name: 'updated_at', type: 'carbon_immutable', nullable: false)]
    private DateTimeImmutable $updatedAt;

    #[Assert\DateTime(message: 'lastLoggedIn must be a valid DateTime')]
    #[ORM\Column(name: 'last_logged_in', type: 'carbon_immutable', nullable: true)]
    private ?DateTimeImmutable $lastLoggedIn = null;

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        $roles = array_unique($roles);
        sort($roles);

        return $roles;
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function clearRoles(): static
    {
        $this->roles = [];

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getLastLoggedIn(): ?DateTimeImmutable
    {
        return $this->lastLoggedIn;
    }

    public function setLastLoggedIn(?DateTimeImmutable $lastLoggedIn): static
    {
        $this->lastLoggedIn = $lastLoggedIn;

        return $this;
    }
}
