<?php

namespace App\Entity;

use App\Repository\QuizzRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: QuizzRepository::class)]
class Quizz
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected UuidInterface|string $id;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'quizz_id', targetEntity: UserQuizz::class, orphanRemoval: true)]
    private Collection $user_quizz;

    #[ORM\OneToOne(inversedBy: 'chapter', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chapters $chaptre_id = null;

    #[ORM\OneToMany(mappedBy: 'quizz_id', targetEntity: Questions::class, orphanRemoval: true)]
    private Collection $questions;

    public function __construct()
    {
        $this->user_quizz = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }



    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, UserQuizz>
     */
    public function getUserQuizz(): Collection
    {
        return $this->user_quizz;
    }

    public function addUserQuizz(UserQuizz $userQuizz): self
    {
        if (!$this->user_quizz->contains($userQuizz)) {
            $this->user_quizz->add($userQuizz);
            $userQuizz->setQuizzId($this);
        }

        return $this;
    }

    public function removeUserQuizz(UserQuizz $userQuizz): self
    {
        if ($this->user_quizz->removeElement($userQuizz)) {
            // set the owning side to null (unless already changed)
            if ($userQuizz->getQuizzId() === $this) {
                $userQuizz->setQuizzId(null);
            }
        }

        return $this;
    }

    public function getChaptreId(): ?Chapters
    {
        return $this->chaptre_id;
    }

    public function setChaptreId(Chapters $chaptre_id): self
    {
        $this->chaptre_id = $chaptre_id;

        return $this;
    }

    /**
     * @return Collection<int, Questions>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Questions $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuizzId($this);
        }

        return $this;
    }

    public function removeQuestion(Questions $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuizzId() === $this) {
                $question->setQuizzId(null);
            }
        }

        return $this;
    }

}
