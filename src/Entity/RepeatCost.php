<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\GetId;
use App\Entity\Traits\SetId;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class RepeatCost
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

    #[Assert\Length(max: 10, maxMessage: 'Cost cannot be more than 10 digits')]
    #[Assert\NotBlank(message: 'Cost cannot be empty')]
    #[Assert\Type('integer', message: 'Cost must be an integer')]
    #[ORM\Column(length: 10)]
    private int $cost;

    #[Assert\NotNull(message: 'Date cannot be null')]
    #[ORM\Column(name: 'date', type: 'carbon_immutable', nullable: false)]
    private DateTimeImmutable $date;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
}
