<?php

namespace App\Entity;

use App\Repository\UserQuestionAnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=UserQuestionAnswerRepository::class)
 */
class UserQuestionAnswer
{

    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userQuestionAnswers")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="userQuestionAnswers")
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity=Answer::class, inversedBy="userQuestionAnswers")
     */
    private $answer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_correct = false;

    /**
     * @ORM\Column(type="integer")
     */
    private $points = 0;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=UserQuizzTake::class, inversedBy="userQuestionAnswers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_quizz_take;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $answer_text;

    /**
     * @ORM\Column(type="integer")
     */
    private $question_type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $possible_points;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getIsCorrect(): ?bool
    {
        return $this->is_correct;
    }

    public function setIsCorrect(bool $is_correct): self
    {
        $this->is_correct = $is_correct;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getUserQuizzTake(): ?UserQuizzTake
    {
        return $this->user_quizz_take;
    }

    public function setUserQuizzTake(?UserQuizzTake $user_quizz_take): self
    {
        $this->user_quizz_take = $user_quizz_take;

        return $this;
    }

    public function getAnswerText(): ?string
    {
        return $this->answer_text;
    }

    public function setAnswerText(?string $answer_text): self
    {
        $this->answer_text = $answer_text;

        return $this;
    }

    public function getQuestionType(): ?int
    {
        return $this->question_type;
    }

    public function setQuestionType(int $question_type): self
    {
        $this->question_type = $question_type;

        return $this;
    }

    public function getPossiblePoints(): ?int
    {
        return $this->possible_points;
    }

    public function setPossiblePoints(?int $possible_points): self
    {
        $this->possible_points = $possible_points;

        return $this;
    }
}
