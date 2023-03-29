<?php

namespace App\Entity;

use App\Repository\ChaptersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: ChaptersRepository::class)]
class Chapters
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected UuidInterface|string $id;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'chaptre')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formations $formation_id = null;

    #[ORM\OneToMany(mappedBy: 'chapter_id', targetEntity: Lesson::class, orphanRemoval: true)]
    private Collection $lessons;

    #[ORM\OneToOne(mappedBy: 'chaptre_id', cascade: ['persist', 'remove'])]
    private ?Quizz $chapter = null;


    public function __construct()
    {
        $this->lessons = new ArrayCollection();
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

    public function getFormationId(): ?Formations
    {
        return $this->formation_id;
    }

    public function setFormationId(?Formations $formation_id): self
    {
        $this->formation_id = $formation_id;

        return $this;
    }

    /**
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons->add($lesson);
            $lesson->setChapterId($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getChapterId() === $this) {
                $lesson->setChapterId(null);
            }
        }

        return $this;
    }

    public function getChapter(): ?Quizz
    {
        return $this->chapter;
    }

    public function setChapter(Quizz $chapter): self
    {
        // set the owning side of the relation if necessary
        if ($chapter->getChaptreId() !== $this) {
            $chapter->setChaptreId($this);
        }

        $this->chapter = $chapter;

        return $this;
    }


}
