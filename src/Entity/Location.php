<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity=Area::class, inversedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity=LocationType::class, inversedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="sublocations")
     */
    private $sublocations;

    public function __construct()
    {
        $this->sublocations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function setArea(?Area $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getType(): ?LocationType
    {
        return $this->type;
    }

    public function setType(?LocationType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSublocations(): ?self
    {
        return $this->sublocations;
    }

    public function setSublocations(?self $sublocations): self
    {
        $this->sublocations = $sublocations;

        return $this;
    }

    public function addSublocation(self $sublocation): self
    {
        if (!$this->sublocations->contains($sublocation)) {
            $this->sublocations[] = $sublocation;
            $sublocation->setSublocations($this);
        }

        return $this;
    }

    public function removeSublocation(self $sublocation): self
    {
        if ($this->sublocations->removeElement($sublocation)) {
            // set the owning side to null (unless already changed)
            if ($sublocation->getSublocations() === $this) {
                $sublocation->setSublocations(null);
            }
        }

        return $this;
    }
}
