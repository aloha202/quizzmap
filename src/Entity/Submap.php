<?php

namespace App\Entity;

use App\Repository\SubmapRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubmapRepository::class)
 */
class Submap
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Location::class, inversedBy="submap", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $mapsize;

    /**
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="parent_map")
     */
    private $locations;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getMapsize(): ?string
    {
        return $this->mapsize;
    }

    public function setMapsize(?string $mapsize): self
    {
        $this->mapsize = $mapsize;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setParentMap($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getParentMap() === $this) {
                $location->setParentMap(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getLocation()->getName();
    }
}
