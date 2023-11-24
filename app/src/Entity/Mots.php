<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use App\Repository\MotsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotsRepository::class)]
class Mots
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mot = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $onlineAt = null;
    public function getId(): ?int
    {
        return $this->id;
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

    public function getOnlineAt(): ?\DateTimeImmutable
    {
        return $this->onlineAt;
    }

    public function setOnlineAt(\DateTimeImmutable $onlineAt): static
    {
        $this->onlineAt = $onlineAt;

        return $this;
    }


    /**
     * @ORM\ManyToOne(targetEntity="Mots")
     * @ORM\JoinColumn(name="id_mot", referencedColumnName="id")
     */
    private $motAssocie;


    public function getMotAssocie(): ?Mots
    {
        return $this->motAssocie;
    }

    public function setMotAssocie(?Mots $motAssocie): self
    {
        $this->motAssocie = $motAssocie;

        // Vous n'avez généralement pas besoin de définir $this->id_mot manuellement,
        // car Doctrine s'occupe de cela lorsqu'il persiste l'entité.

        return $this;
    }

   
}
