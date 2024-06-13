<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\SetId;
use App\Repository\ExpenseCategoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpenseCategoryRepository::class)]
class ExpenseCategory
{
    use SetId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[Assert\Length(max: 255, maxMessage: 'Name cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Name cannot be empty')]
    #[Assert\NotNull(message: 'Name cannot be null')]
    #[Assert\Type('string', message: 'Name must be a string')]
    #[ORM\Column(length: 255)]
    private string $name;

    #[Assert\NotBlank(message: 'Description cannot be empty')]
    #[Assert\NotNull(message: 'Description cannot be null')]
    #[Assert\Type('string', message: 'Description must be a string')]
    #[ORM\Column(type: Types::TEXT)]
    private string $description;

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
