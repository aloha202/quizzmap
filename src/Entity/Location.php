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
     * @ORM\OneToMany(targetEntity=UserQuizzTake::class, mappedBy="location", orphanRemoval=true)
     */
    private $userQuizzTakes;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="locations")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="parent")
     */
    private $locations;

    public function __construct()
    {
        $this->userQuizzTakes = new ArrayCollection();
        $this->locations = new ArrayCollection();
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

    public function getLeft():int
    {
        $expl = explode('x', $this->position);
        return intval($expl[0]);
    }

    public function getTop():int
    {
        $expl = explode('x', $this->position);
        return intval($expl[1]);
    }

    /**
     * @return Collection|UserQuizzTake[]
     */
    public function getUserQuizzTakes(): Collection
    {
        return $this->userQuizzTakes;
    }

    public function addUserQuizzTake(UserQuizzTake $userQuizzTake): self
    {
        if (!$this->userQuizzTakes->contains($userQuizzTake)) {
            $this->userQuizzTakes[] = $userQuizzTake;
            $userQuizzTake->setLocation($this);
        }

        return $this;
    }

    public function removeUserQuizzTake(UserQuizzTake $userQuizzTake): self
    {
        if ($this->userQuizzTakes->removeElement($userQuizzTake)) {
            // set the owning side to null (unless already changed)
            if ($userQuizzTake->getLocation() === $this) {
                $userQuizzTake->setLocation(null);
            }
        }

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(self $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setParent($this);
        }

        return $this;
    }

    public function removeLocation(self $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getParent() === $this) {
                $location->setParent(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }


}
