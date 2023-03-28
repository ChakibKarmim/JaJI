<?php

namespace App\Entity;

use App\Repository\CareerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: CareerRepository::class)]
class Career
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected UuidInterface|string $id;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'career', targetEntity: User::class, orphanRemoval: true)]
    private Collection $user_id;

    #[ORM\OneToMany(mappedBy: 'career', targetEntity: Formations::class, orphanRemoval: true)]
    private Collection $formation_id;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
        $this->formation_id = new ArrayCollection();
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
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id->add($userId);
            $userId->setCareer($this);
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        if ($this->user_id->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getCareer() === $this) {
                $userId->setCareer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Formations>
     */
    public function getFormationId(): Collection
    {
        return $this->formation_id;
    }

    public function addFormationId(Formations $formationId): self
    {
        if (!$this->formation_id->contains($formationId)) {
            $this->formation_id->add($formationId);
            $formationId->setCareer($this);
        }

        return $this;
    }

    public function removeFormationId(Formations $formationId): self
    {
        if ($this->formation_id->removeElement($formationId)) {
            // set the owning side to null (unless already changed)
            if ($formationId->getCareer() === $this) {
                $formationId->setCareer(null);
            }
        }

        return $this;
    }

}
