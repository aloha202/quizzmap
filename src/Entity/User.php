<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    use TimestampableEntity;

    const STATUS_ANON = 'anon';
    const STATUS_PENDING = 'pending';
    const STATUS_REGISTERED = 'registered';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $points = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=UserQuestionAnswer::class, mappedBy="user")
     */
    private $userQuestionAnswers;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity=UserQuizzTake::class, mappedBy="user", orphanRemoval=true)
     */
    private $userQuizzTakes;

    public function __construct()
    {
        $this->userQuestionAnswers = new ArrayCollection();
        $this->userQuizzTakes = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->email;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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
            $userQuestionAnswer->setUser($this);
        }

        return $this;
    }

    public function removeUserQuestionAnswer(UserQuestionAnswer $userQuestionAnswer): self
    {
        if ($this->userQuestionAnswers->removeElement($userQuestionAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userQuestionAnswer->getUser() === $this) {
                $userQuestionAnswer->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles(): ?array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getRealName():string
    {
        return $this->getName() ? $this->getName() : ($this->getStatus() == self::STATUS_ANON ? 'Anon' : $this->getEmail());
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
            $userQuizzTake->setUser($this);
        }

        return $this;
    }

    public function removeUserQuizzTake(UserQuizzTake $userQuizzTake): self
    {
        if ($this->userQuizzTakes->removeElement($userQuizzTake)) {
            // set the owning side to null (unless already changed)
            if ($userQuizzTake->getUser() === $this) {
                $userQuizzTake->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getEmail();
    }

    public function addPoints($points):void
    {
        $this->points += $points;
    }


}
