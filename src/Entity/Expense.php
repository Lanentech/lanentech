<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Const\Expense as ExpenseConstants;
use App\Entity\Traits\GetId;
use App\Entity\Traits\SetId;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Expense
{
    use GetId;
    use SetId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(max: 255, maxMessage: 'Description cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Description cannot be empty')]
    #[Assert\Type('string', message: 'Description must be a string')]
    #[ORM\Column(length: 255)]
    private string $description;

    #[Assert\Type(type: ExpenseCategory::class, message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[ORM\ManyToOne(inversedBy: 'expenses')]
    private ?ExpenseCategory $category = null;

    #[Assert\Choice(
        choices: ExpenseConstants::TYPES,
        message: 'Type invalid. Must be one of: {{ choices }}',
    )]
    #[Assert\Length(max: 17, maxMessage: 'Type cannot be more than 17 characters')]
    #[Assert\NotBlank(message: 'Type cannot be empty')]
    #[Assert\Type('string', message: 'Type must be a string')]
    #[ORM\Column(length: 17)]
    private string $type;

    #[Assert\Length(max: 10, maxMessage: 'Cost cannot be more than 10 digits')]
    #[Assert\NotBlank(message: 'Cost cannot be empty')]
    #[Assert\Type('integer', message: 'Cost must be an integer')]
    #[ORM\Column(length: 10)]
    private int $cost;

    #[Assert\NotNull(message: 'Date cannot be null')]
    #[ORM\Column(name: 'date', type: 'carbon_immutable', nullable: false)]
    private DateTimeImmutable $date;

    #[Assert\Length(max: 5000, maxMessage: 'Comments cannot be more than 5000 characters')]
    #[Assert\Type('string', message: 'Comments must be a string')]
    #[ORM\Column(type: Types::TEXT, length: 5000, nullable: true)]
    private ?string $comments = null;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?ExpenseCategory
    {
        return $this->category;
    }

    public function setCategory(?ExpenseCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function setCost(int $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): static
    {
        $this->comments = $comments;

        return $this;
    }
}
