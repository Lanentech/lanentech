<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Const\Company as CompanyConstants;
use App\Entity\Traits\GetId;
use App\Entity\Traits\SetId;
use App\Validator\Constraint\Billables;
use App\Validator\Constraint\Slug;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Company
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

    #[Assert\Length(max: 255, maxMessage: 'Ident cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Ident cannot be empty')]
    #[Assert\Type('string', message: 'Ident must be a string')]
    #[Slug]
    #[ORM\Column(length: 255)]
    private string $ident;

    #[Assert\Choice(
        choices: CompanyConstants::TYPES,
        message: 'Type invalid. Must be one of: {{ choices }}',
    )]
    #[Assert\Length(max: 255, maxMessage: 'Type cannot be more than 255 characters')]
    #[Assert\NotBlank(message: 'Type cannot be empty')]
    #[Assert\Type('string', message: 'Type must be a string')]
    #[ORM\Column(length: 255)]
    private string $type;

    #[Assert\Length(max: 8, maxMessage: 'Company Number cannot be more than 8 digits')]
    #[Assert\NotBlank(message: 'Company Number cannot be empty')]
    #[Assert\Type('integer', message: 'Company Number must be an integer')]
    #[ORM\Column(length: 8)]
    private int $companyNumber;

    #[Assert\Type(type: Address::class, message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Address $address = null;

    /**
     * @var Collection<int, Billable>
     */
    #[Billables]
    #[ORM\OneToMany(targetEntity: Billable::class, mappedBy: 'client')]
    private Collection $billables;

    public function __construct()
    {
        $this->billables = new ArrayCollection();
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

    public function getIdent(): string
    {
        return $this->ident;
    }

    public function setIdent(string $ident): static
    {
        $this->ident = $ident;

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

    public function getCompanyNumber(): int
    {
        return $this->companyNumber;
    }

    public function setCompanyNumber(int $companyNumber): static
    {
        $this->companyNumber = $companyNumber;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Billable>
     */
    public function getBillables(): Collection
    {
        return $this->billables;
    }

    public function addBillable(Billable $billable): static
    {
        if (!$this->billables->contains($billable)) {
            $this->billables->add($billable);
            $billable->setClient($this);
        }

        return $this;
    }

    public function removeBillable(Billable $billable): static
    {
        if ($this->billables->removeElement($billable)) {
            // set the owning side to null (unless already changed)
            if ($billable->getClient() === $this) {
                $billable->setClient(null);
            }
        }

        return $this;
    }
}
