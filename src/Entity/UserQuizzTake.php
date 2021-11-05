<?php

namespace App\Entity;

use App\Repository\UserQuizzTakeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=UserQuizzTakeRepository::class)
 */
class UserQuizzTake
{


    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="userQuizzTakes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userQuizzTakes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $points = 0;

    /**
     * @ORM\OneToMany(targetEntity=UserQuestionAnswer::class, mappedBy="user_quizz_take", orphanRemoval=true)
     */
    private $userQuestionAnswers;

    public function __construct()
    {
        $this->userQuestionAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }

    /**
     * @return Collection|UserQuestionAnswer[]
     */
    public function getUserQuestionAnswers(): Collection
    {
        return $this->userQuestionAnswers;
    }

    public function addUserQuestionAnswer(UserQuestionAnswer $userQuestionAnswer): self
    {
        if (!$this->userQuestionAnswers->contains($userQuestionAnswer)) {
            $this->userQuestionAnswers[] = $userQuestionAnswer;
            $userQuestionAnswer->setUserQuizzTake($this);
        }

        return $this;
    }

    public function removeUserQuestionAnswer(UserQuestionAnswer $userQuestionAnswer): self
    {
        if ($this->userQuestionAnswers->removeElement($userQuestionAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userQuestionAnswer->getUserQuizzTake() === $this) {
                $userQuestionAnswer->setUserQuizzTake(null);
            }
        }

        return $this;
    }

    public function addPoints($points):void
    {
        $this->points += $points;
    }
}
