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

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $projectDate = null;

    #[ORM\Column(type: "string", enumType: Proposal::class)]
    private ?Proposal $proposal = Proposal::Bill;

    #[ORM\Column(type: "string", enumType: Urgency::class)]
    private ?Urgency $urgency;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $creationDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $editionDate = null;

    #[ORM\ManyToOne(inversedBy: 'claims')]
    private ?User $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $materials = null;

    #[ORM\ManyToOne(inversedBy: 'describes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeSite $typeSite = null;


    public function __construct()
    {
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


    public function getProjectDate(): ?\DateTimeImmutable
    {
        return $this->projectDate;
    }

    public function setProjectDate(\DateTimeImmutable $projectDate): static
    {
        $this->projectDate = $projectDate;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getMaterials(): ?string
    {
        return $this->materials;
    }

    public function setMaterials(?string $materials): static
    {
        $this->materials = $materials;

        return $this;
    }

    public function getTypeSite(): ?TypeSite
    {
        return $this->typeSite;
    }

    public function setTypeSite(?TypeSite $typeSite): static
    {
        $this->typeSite = $typeSite;

        return $this;
    }
}
