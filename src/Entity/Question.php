<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Answer;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{

    const CONST_LEVEL_BEGINNER = 1;
    const CONST_LEVEL_INTERMEDIATE = 2;
    const CONST_LEVEL_ADVANCED = 3;

    const CONST_TYPE_DEFAULT = 1;
    const CONST_TYPE_PARSER = 2;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity=LocationType::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location_type;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question", orphanRemoval=true, cascade={"persist"})
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity=UserQuestionAnswer::class, mappedBy="question")
     */
    private $userQuestionAnswers;


    private $pre_answers;

    /**
     * @ORM\Column(type="integer")
     */
    private $type = 1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $points;


    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->userQuestionAnswers = new ArrayCollection();
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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getLocationType(): ?LocationType
    {
        return $this->location_type;
    }

    public function setLocationType(?LocationType $location_type): self
    {
        $this->location_type = $location_type;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

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
            $userQuestionAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeUserQuestionAnswer(UserQuestionAnswer $userQuestionAnswer): self
    {
        if ($this->userQuestionAnswers->removeElement($userQuestionAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userQuestionAnswer->getQuestion() === $this) {
                $userQuestionAnswer->setQuestion(null);
            }
        }

        return $this;
    }


    public function getPreAnswers()
    {
        return $this->pre_answers;
    }

    public function setPreAnswers($pre_answers)
    {
        $this->pre_answers = $pre_answers;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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


}
