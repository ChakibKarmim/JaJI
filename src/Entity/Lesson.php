<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected UuidInterface|string $id;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chapters $chapter_id = null;

    #[ORM\OneToMany(mappedBy: 'lesson', targetEntity: UserLessons::class, orphanRemoval: true)]
    private Collection $user_lessons;

    public function __construct()
    {
        $this->user_lessons = new ArrayCollection();
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

    public function getChapterId(): ?Chapters
    {
        return $this->chapter_id;
    }

    public function setChapterId(?Chapters $chapter_id): self
    {
        $this->chapter_id = $chapter_id;

        return $this;
    }

    /**
     * @return Collection<int, UserLessons>
     */
    public function getUserLessons(): Collection
    {
        return $this->user_lessons;
    }

    public function addUserLesson(UserLessons $userLesson): self
    {
        if (!$this->user_lessons->contains($userLesson)) {
            $this->user_lessons->add($userLesson);
            $userLesson->setLesson($this);
        }

        return $this;
    }

    public function removeUserLesson(UserLessons $userLesson): self
    {
        if ($this->user_lessons->removeElement($userLesson)) {
            // set the owning side to null (unless already changed)
            if ($userLesson->getLesson() === $this) {
                $userLesson->setLesson(null);
            }
        }

        return $this;
    }


}
