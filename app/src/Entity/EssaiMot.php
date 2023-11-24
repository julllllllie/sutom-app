<?php
namespace App\Entity;

use App\Repository\EssaiMotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EssaiMotRepository::class)]
class EssaiMot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $tentative = null;

    #[ORM\Column(length: 255)]
    private ?string $resultat = null;

    #[ORM\Column(length: 255)]
    private ?string $mot = null;

    private $motAssocie;

    #[ORM\Column]
    private ?int $idMot = null;

    #[ORM\Column]
    private ?int $idu = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTentative(): ?int
    {
        return $this->tentative;
    }

    public function setTentative(int $tentative): static
    {
        $this->tentative = $tentative;

        return $this;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(string $resultat): static
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getMot(): ?string
    {
        return $this->mot;
    }

    public function setMot(string $mot): static
    {
        $this->mot = $mot;

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

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function setIdu(int $idu): static
    {
        $this->idu = $idu;

        return $this;
    }


  
}
