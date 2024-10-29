<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\GetId;
use App\Entity\Traits\SetId;
use App\Validator\Constraint\Directors;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Lanentech
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

    #[Assert\Length(max: 8, maxMessage: 'Company Number cannot be more than 8 digits')]
    #[Assert\NotBlank(message: 'Company Number cannot be empty')]
    #[Assert\Type('integer', message: 'Company Number must be an integer')]
    #[ORM\Column(length: 8)]
    private int $companyNumber;

    /**
     * @var Collection<int, Director>
     */
    #[Directors]
    #[ORM\OneToMany(targetEntity: Director::class, mappedBy: 'company')]
    private Collection $directors;

    #[Assert\DateTime(message: 'Incorporation Date must be a valid DateTime')]
    #[Assert\NotNull(message: 'Incorporation Date cannot be null')]
    #[ORM\Column(name: 'incorporation_date', type: 'carbon_immutable', nullable: false)]
    private DateTimeImmutable $incorporationDate;

    public function __construct()
    {
        $this->directors = new ArrayCollection();
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

    public function getCompanyNumber(): int
    {
        return $this->companyNumber;
    }

    public function setCompanyNumber(int $companyNumber): static
    {
        $this->companyNumber = $companyNumber;

        return $this;
    }

    /**
     * @return Collection<int, Director>
     */
    public function getDirectors(): Collection
    {
        return $this->directors;
    }

    public function addDirector(Director $director): static
    {
        if (!$this->directors->contains($director)) {
            $this->directors->add($director);
            $director->setCompany($this);
        }

        return $this;
    }

    public function removeDirector(Director $director): static
    {
        if ($this->directors->removeElement($director)) {
            if ($director->getCompany() === $this) {
                $director->setCompany(null);
            }
        }

        return $this;
    }

    public function getIncorporationDate(): DateTimeImmutable
    {
        return $this->incorporationDate;
    }

    public function setIncorporationDate(DateTimeImmutable $createdAt): static
    {
        $this->incorporationDate = $createdAt;

        return $this;
    }
}
