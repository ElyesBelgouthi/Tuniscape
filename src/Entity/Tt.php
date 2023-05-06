<?php

namespace App\Entity;

use App\Repository\TtRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TtRepository::class)]
class Tt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $t = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getT(): ?string
    {
        return $this->t;
    }

    public function setT(string $t): self
    {
        $this->t = $t;

        return $this;
    }
}
