<?php

namespace App\Entity;

use App\Repository\UserQuizzRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: UserQuizzRepository::class)]
class UserQuizz
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected UuidInterface|string $id;


    #[ORM\ManyToOne(inversedBy: 'user_quizz')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'user_quizz')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quizz $quizz_id = null;

    #[ORM\Column]
    private ?bool $is_passed = null;

    #[ORM\Column]
    private ?bool $is_valid = null;

    #[ORM\Column]
    private ?bool $is_completed = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getQuizzId(): ?Quizz
    {
        return $this->quizz_id;
    }

    public function setQuizzId(?Quizz $quizz_id): self
    {
        $this->quizz_id = $quizz_id;

        return $this;
    }

    public function isIsPassed(): ?bool
    {
        return $this->is_passed;
    }

    public function setIsPassed(bool $is_passed): self
    {
        $this->is_passed = $is_passed;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->is_valid;
    }

    public function setIsValid(bool $is_valid): self
    {
        $this->is_valid = $is_valid;

        return $this;
    }

    public function isIsCompleted(): ?bool
    {
        return $this->is_completed;
    }

    public function setIsCompleted(bool $is_completed): self
    {
        $this->is_completed = $is_completed;

        return $this;
    }

}
