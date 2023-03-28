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

    #[ORM\Column]
    private ?int $result = null;

    #[ORM\ManyToOne(inversedBy: 'user_quizz')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'user_quizz')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quizz $quizz_id = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): self
    {
        $this->result = $result;

        return $this;
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

}
