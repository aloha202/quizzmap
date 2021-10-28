<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer
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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_correct;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="answers", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=UserQuestionAnswer::class, mappedBy="answer")
     */
    private $userQuestionAnswers;

    public function __construct($values = [])
    {
        $this->userQuestionAnswers = new ArrayCollection();

        if(!empty($values['name'])){
            $this->name = $values['name'];
        }

        if(!empty($values['is_correct'])){
            $this->is_correct = $values['is_correct'];
        }
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

    public function getIsCorrect(): ?bool
    {
        return $this->is_correct;
    }

    public function setIsCorrect(?bool $is_correct): self
    {
        $this->is_correct = $is_correct;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

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
            $userQuestionAnswer->setAnswer($this);
        }

        return $this;
    }

    public function removeUserQuestionAnswer(UserQuestionAnswer $userQuestionAnswer): self
    {
        if ($this->userQuestionAnswers->removeElement($userQuestionAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userQuestionAnswer->getAnswer() === $this) {
                $userQuestionAnswer->setAnswer(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }


}
