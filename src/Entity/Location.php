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

    /**
     * @ORM\Column(type="integer")
     */
    private $num_of_questions = 10;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pass_rate = 7;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min_points;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min_rating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $difficulty_from;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $difficulty_to;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\OneToOne(targetEntity=Submap::class, mappedBy="location", cascade={"persist", "remove"})
     */
    private $submap;

    /**
     * @ORM\ManyToOne(targetEntity=Submap::class, inversedBy="locations")
     */
    private $parent_map;
    

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

    public function getNumOfQuestions(): ?int
    {
        return $this->num_of_questions;
    }

    public function setNumOfQuestions(int $num_of_questions): self
    {
        $this->num_of_questions = $num_of_questions;

        return $this;
    }

    public function getPassRate(): ?int
    {
        return $this->pass_rate;
    }

    public function setPassRate(?int $pass_rate): self
    {
        $this->pass_rate = $pass_rate;

        return $this;
    }

    public function getMinPoints(): ?int
    {
        return $this->min_points;
    }

    public function setMinPoints(?int $min_points): self
    {
        $this->min_points = $min_points;

        return $this;
    }

    public function getMinRating(): ?int
    {
        return $this->min_rating;
    }

    public function setMinRating(?int $min_rating): self
    {
        $this->min_rating = $min_rating;

        return $this;
    }

    public function getDifficultyFrom(): ?int
    {
        return $this->difficulty_from;
    }

    public function setDifficultyFrom(?int $difficulty_from): self
    {
        $this->difficulty_from = $difficulty_from;

        return $this;
    }

    public function getDifficultyTo(): ?int
    {
        return $this->difficulty_to;
    }

    public function setDifficultyTo(?int $difficulty_to): self
    {
        $this->difficulty_to = $difficulty_to;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getSubmap(): ?Submap
    {
        return $this->submap;
    }

    public function setSubmap(Submap $submap): self
    {
        // set the owning side of the relation if necessary
        if ($submap->getLocation() !== $this) {
            $submap->setLocation($this);
        }

        $this->submap = $submap;

        return $this;
    }

    public function getParentMap(): ?Submap
    {
        return $this->parent_map;
    }

    public function setParentMap(?Submap $parent_map): self
    {
        $this->parent_map = $parent_map;

        return $this;
    }


}
