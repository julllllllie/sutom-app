<?php

namespace App\Entity;

use App\Repository\NotesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotesRepository::class)]
class Notes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idMot = null;

    #[ORM\Column(length: 255)]
    private ?string $note = null;

    

    #[ORM\Column]
    private ?int $idu = null;

    #[ORM\Column(nullable: true)]
    private ?int $aime = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

        return $this;
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

    public function getAime(): ?int
    {
        return $this->aime;
    }

    public function setAime(?int $aime): static
    {
        $this->aime = $aime;

        return $this;
    }
}
