<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: SousSection::class)]
    private Collection $sousSections;

    public function __construct()
    {
        $this->sousSections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, SousSection>
     */
    public function getSousSections(): Collection
    {
        return $this->sousSections;
    }

    public function addSousSection(SousSection $sousSection): static
    {
        if (!$this->sousSections->contains($sousSection)) {
            $this->sousSections->add($sousSection);
            $sousSection->setSection($this);
        }

        return $this;
    }

    public function removeSousSection(SousSection $sousSection): static
    {
        if ($this->sousSections->removeElement($sousSection)) {
            // set the owning side to null (unless already changed)
            if ($sousSection->getSection() === $this) {
                $sousSection->setSection(null);
            }
        }

        return $this;
    }
}
