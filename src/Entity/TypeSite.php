<?php

namespace App\Entity;

use App\Repository\TypeSiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeSiteRepository::class)]
class TypeSite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $labelSite = null;

    #[ORM\Column(nullable: true)]
    private ?int $teamSize = null;

    /**
     * @var Collection<int, Yard>
     */
    #[ORM\OneToMany(targetEntity: Yard::class, mappedBy: 'typeSite')]
    private Collection $describes;

    public function __construct()
    {
        $this->describes = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabelSite(): ?string
    {
        return $this->labelSite;
    }

    public function setLabelSite(string $labelSite): static
    {
        $this->labelSite = $labelSite;

        return $this;
    }

    public function getTeamSize(): ?int
    {
        return $this->teamSize;
    }

    public function setTeamSize(?int $teamSize): static
    {
        $this->teamSize = $teamSize;

        return $this;
    }
    public function __toString()
    {
        return $this->labelSite;
    }

    /**
     * @return Collection<int, Yard>
     */
    public function getDescribes(): Collection
    {
        return $this->describes;
    }

    public function setDescribes(Yard $describe): static
    {
        if (!$this->describes->contains($describe)) {
            $this->describes->add($describe);
            $describe->setTypeSite($this);
        }

        return $this;
    }

    public function removeDescribe(Yard $describe): static
    {
        if ($this->describes->removeElement($describe)) {
            // set the owning side to null (unless already changed)
            if ($describe->getTypeSite() === $this) {
                $describe->setTypeSite(null);
            }
        }

        return $this;
    }
}
