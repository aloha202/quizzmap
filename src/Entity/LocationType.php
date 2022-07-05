<?php

namespace App\Entity;

use App\Repository\LocationTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationTypeRepository::class)
 */
class LocationType
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
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="type", orphanRemoval=true)
     */
    private $locations;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="location_type", orphanRemoval=true)
     */
    private $questions;

    /**
     * @ORM\ManyToOne(targetEntity=LocationType::class, inversedBy="childLocationTypes")
     */
    private $parent_location_type;

    /**
     * @ORM\OneToMany(targetEntity=LocationType::class, mappedBy="parent_location_type")
     */
    private $childLocationTypes;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->childLocationTypes = new ArrayCollection();
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
            $location->setType($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getType() === $this) {
                $location->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setLocationType($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getLocationType() === $this) {
                $question->setLocationType(null);
            }
        }

        return $this;
    }

    public function __toString(){
        if($this->getParentLocationType()){
            return $this->getParentLocationType() . ':' . $this->getName();
        }else {
            return $this->getName();
        }
    }

    public function getParentLocationType(): ?self
    {
        return $this->parent_location_type;
    }

    public function setParentLocationType(?self $parent_location_type): self
    {
        $this->parent_location_type = $parent_location_type;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildLocationTypes(): Collection
    {
        return $this->childLocationTypes;
    }

    public function addChildLocationType(self $childLocationType): self
    {
        if (!$this->childLocationTypes->contains($childLocationType)) {
            $this->childLocationTypes[] = $childLocationType;
            $childLocationType->setParentLocationType($this);
        }

        return $this;
    }

    public function removeChildLocationType(self $childLocationType): self
    {
        if ($this->childLocationTypes->removeElement($childLocationType)) {
            // set the owning side to null (unless already changed)
            if ($childLocationType->getParentLocationType() === $this) {
                $childLocationType->setParentLocationType(null);
            }
        }

        return $this;
    }
}
