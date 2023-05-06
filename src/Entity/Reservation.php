<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ReservationRepository::class),ORM\HasLifecycleCallbacks()]

class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;
    /**
     * @ORM\OneToMany(targetEntity=ReservationAccommodation::class, mappedBy="accommodation")
     */
    private Collection $reservations;
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToMany(targetEntity: Activity::class, mappedBy: "reservations")]
    private Collection $activity;

    #[ORM\ManyToMany(targetEntity: Accommodation::class, mappedBy: "reservations")]
    private Collection $Accommodations;

    #[ORM\ManyToMany(targetEntity: Food::class, mappedBy: "reservations"),]
    private Collection $foods;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne]
    private ?User $user_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->activity = new ArrayCollection();
        $this->Accommodations = new ArrayCollection();
        $this->foods = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivity(): Collection
    {
        return $this->activity;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activity->contains($activity)) {
            $this->activity->add($activity);
        }

        return $this;
    }



    /**
     * @return Collection<int, Accommodation>
     */
    public function getAccommodations(): Collection
    {
        return $this->Accommodations;
    }

    public function addAccommodation(Accommodation $accommodation): self
    {
        if (!$this->Accommodations->contains($accommodation)) {
            $this->Accommodations->add($accommodation);
        }

        return $this;
    }



    /**
     * @return Collection<int, Food>
     */
    public function getFoods(): Collection
    {
        return $this->foods;
    }
    public function getActivities(): Collection
    {
        return $this->activity;
    }

    public function addFood(Food $food): self
    {
        if (!$this->foods->contains($food)) {
            $this->foods->add($food);
        }

        return $this;
    }

    public function removeFood(Food $food): self
    {
        $this->foods->removeElement($food);
        $food->removeReservation($this); // Add this line
        return $this;
    }

    public function removeAccommodation(Accommodation $accommodation): self
    {
        $this->Accommodations->removeElement($accommodation);
        $accommodation->removeReservation($this); // Add this line
        return $this;
    }
    public function removeActivity (Activity $activity): self
    {
        $this->activity->removeElement($activity);
        $activity->removeReservation($this); // Add this line
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
