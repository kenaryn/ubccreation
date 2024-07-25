<?php

namespace App\Entity;

use App\Repository\YardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: YardRepository::class)]
class Yard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(nullable: true)]
    private ?int $budget = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: "string", enumType: Proposal::class)]
    private ?Proposal $proposal;

    #[ORM\Column(type: "string", enumType: Urgency::class)]
    private ?Urgency $urgency;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $creationDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $editionDate = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'claimedBy')]
    private Collection $claim;

    public function __construct()
    {
        $this->claim = new ArrayCollection();
    }

    public function getProposal(): ?Proposal
    {
        return $this->proposal;
    }

    public function setProposal(Proposal $proposal): static
    {
        $this->proposal = $proposal;
        return $this;
    }

    public function getUrgency(): ?Urgency
    {
        return $this->urgency;
    }

    public function setUrgency(Urgency $urgency): static
    {
        $this->urgency = $urgency;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(?int $budget): static
    {
        $this->budget = $budget;

        return $this;
    }


    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeImmutable
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeImmutable $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getEditionDate(): ?\DateTimeImmutable
    {
        return $this->editionDate;
    }

    public function setEditionDate(?\DateTimeImmutable $editionDate): static
    {
        $this->editionDate = $editionDate;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getClaim(): Collection
    {
        return $this->claim;
    }

    public function addClaim(User $claim): static
    {
        if (!$this->claim->contains($claim)) {
            $this->claim->add($claim);
            $claim->setClaimedBy($this);
        }

        return $this;
    }

    public function removeClaim(User $claim): static
    {
        if ($this->claim->removeElement($claim)) {
            // set the owning side to null (unless already changed)
            if ($claim->getClaimedBy() === $this) {
                $claim->setClaimedBy(null);
            }
        }

        return $this;
    }
}
