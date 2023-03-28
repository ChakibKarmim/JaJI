<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected UuidInterface|string $id;
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $roles = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[ORM\ManyToOne(inversedBy: 'user_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Career $career = null;

    #[ORM\OneToMany(mappedBy: 'author_id', targetEntity: Formations::class, orphanRemoval: true)]
    private Collection $author_id;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: UserQuizz::class, orphanRemoval: true)]
    private Collection $user_quizz;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: UserLessons::class, orphanRemoval: true)]
    private Collection $lessons;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formations $user_formations = null;

    #[ORM\ManyToMany(targetEntity: Formations::class, mappedBy: 'formation_users')]
    private Collection $formations;

    public function __construct()
    {
        $this->author_id = new ArrayCollection();
        $this->user_quizz = new ArrayCollection();
        $this->lessons = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    /**
     * @return Collection<int, Formations>
     */
    public function getAuthorId(): Collection
    {
        return $this->author_id;
    }

    public function addAuthorId(Formations $authorId): self
    {
        if (!$this->author_id->contains($authorId)) {
            $this->author_id->add($authorId);
            $authorId->setAuthorId($this);
        }

        return $this;
    }

    public function removeAuthorId(Formations $authorId): self
    {
        if ($this->author_id->removeElement($authorId)) {
            // set the owning side to null (unless already changed)
            if ($authorId->getAuthorId() === $this) {
                $authorId->setAuthorId(null);
            }
        }

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
            $userQuizz->setUserId($this);
        }

        return $this;
    }

    public function removeUserQuizz(UserQuizz $userQuizz): self
    {
        if ($this->user_quizz->removeElement($userQuizz)) {
            // set the owning side to null (unless already changed)
            if ($userQuizz->getUserId() === $this) {
                $userQuizz->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserLessons>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(UserLessons $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons->add($lesson);
            $lesson->setUserId($this);
        }

        return $this;
    }

    public function removeLesson(UserLessons $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getUserId() === $this) {
                $lesson->setUserId(null);
            }
        }

        return $this;
    }

    public function getUserFormations(): ?Formations
    {
        return $this->user_formations;
    }

    public function setUserFormations(?Formations $user_formations): self
    {
        $this->user_formations = $user_formations;

        return $this;
    }

    /**
     * @return Collection<int, Formations>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formations $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->addFormationUser($this);
        }

        return $this;
    }

    public function removeFormation(Formations $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            $formation->removeFormationUser($this);
        }

        return $this;
    }

}
