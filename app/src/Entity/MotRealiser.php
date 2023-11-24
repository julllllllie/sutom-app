<?php

namespace App\Entity;

use App\Repository\MotRealiserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotRealiserRepository::class)]
class MotRealiser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idu = null;

    #[ORM\Column]
    private ?int $idMot = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function setIdu(int $idu): static
    {
        $this->idu = $idu;

        return $this;
    }

    public function getIdMot(): ?int
    {
        return $this->idMot;
    }

    public function setIdMot(int $idMot): static
    {
        $this->idMot = $idMot;

        return $this;
    }
}
