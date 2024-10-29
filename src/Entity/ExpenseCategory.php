<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\GetId;
use App\Entity\Traits\SetId;
use App\Validator\Constraint\Expenses;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class ExpenseCategory
{
    use GetId;
    use SetId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(max: 255, maxMessage: 'Name cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Name cannot be empty')]
    #[Assert\Type('string', message: 'Name must be a string')]
    #[ORM\Column(length: 255)]
    private string $name;

    #[Assert\NotBlank(message: 'Description cannot be empty')]
    #[Assert\Type('string', message: 'Description must be a string')]
    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    /**
     * @var Collection<int, Expense>
     */
    #[Expenses]
    #[ORM\OneToMany(targetEntity: Expense::class, mappedBy: 'category')]
    private Collection $expenses;

    public function __construct()
    {
        $this->expenses = new ArrayCollection();
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

    /**
     * @return Collection<int, Expense>
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }

    public function addExpense(Expense $expense): static
    {
        if (!$this->expenses->contains($expense)) {
            $this->expenses->add($expense);
            $expense->setCategory($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): static
    {
        if ($this->expenses->removeElement($expense)) {
            if ($expense->getCategory() === $this) {
                $expense->setCategory(null);
            }
        }

        return $this;
    }
}
