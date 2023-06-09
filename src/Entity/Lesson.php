<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video_url = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Intro = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column]
    private ?int $lesson_order = null;

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

    public function getVideoUrl(): ?string
    {
        return $this->video_url;
    }

    public function setVideoUrl(?string $video_url): self
    {
        $this->video_url = $video_url;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIntro(): ?string
    {
        return $this->Intro;
    }

    public function setIntro(string $Intro): self
    {
        $this->Intro = $Intro;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getLessonOrder(): ?int
    {
        return $this->lesson_order;
    }

    public function setLessonOrder(int $lesson_order): self
    {
        $this->lesson_order = $lesson_order;
        return $this;
    }

}
