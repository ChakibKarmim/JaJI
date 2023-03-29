<?php

namespace App\Entity;

use App\Repository\FormationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: FormationsRepository::class)]
class Formations
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected UuidInterface|string $id;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 50)]
    private ?string $difficulty = null;

    #[ORM\ManyToOne(inversedBy: 'formation_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Career $career = null;

    #[ORM\ManyToOne(inversedBy: 'author_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author_id = null;

    #[ORM\OneToMany(mappedBy: 'formation_id', targetEntity: Chapters::class, orphanRemoval: true)]
    private Collection $chaptre;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $status = null;

    #[ORM\Column]
    private ?int $nb_lessons = null;

    #[ORM\Column(length: 255)]
    private ?string $cover_url = null;

    #[ORM\OneToMany(mappedBy: 'formation_id', targetEntity: UserFormation::class, orphanRemoval: true)]
    private Collection $users;

    public function __construct()
    {
        $this->chaptre = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getCareer(): ?Career
    {
        return $this->career;
    }

    public function setCareer(?Career $career): self
    {
        $this->career = $career;

        return $this;
    }

    public function getAuthorId(): ?User
    {
        return $this->author_id;
    }

    public function setAuthorId(?User $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }

    /**
     * @return Collection<int, Chapters>
     */
    public function getChaptre(): Collection
    {
        return $this->chaptre;
    }

    public function addChaptre(Chapters $chaptre): self
    {
        if (!$this->chaptre->contains($chaptre)) {
            $this->chaptre->add($chaptre);
            $chaptre->setFormationId($this);
        }

        return $this;
    }

    public function removeChaptre(Chapters $chaptre): self
    {
        if ($this->chaptre->removeElement($chaptre)) {
            // set the owning side to null (unless already changed)
            if ($chaptre->getFormationId() === $this) {
                $chaptre->setFormationId(null);
            }
        }

        return $this;
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

    public function getNbLessons(): ?int
    {
        return $this->nb_lessons;
    }

    public function setNbLessons(int $nb_lessons): self
    {
        $this->nb_lessons = $nb_lessons;

        return $this;
    }

    public function getCoverUrl(): ?string
    {
        return $this->cover_url;
    }

    public function setCoverUrl(string $cover_url): self
    {
        $this->cover_url = $cover_url;

        return $this;
    }

    /**
     * @return Collection<int, UserFormation>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(UserFormation $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setFormationId($this);
        }

        return $this;
    }

    public function removeUser(UserFormation $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getFormationId() === $this) {
                $user->setFormationId(null);
            }
        }

        return $this;
    }

}
