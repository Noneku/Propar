<?php

namespace App\Entity;

use App\Repository\OperationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationsRepository::class)]
class Operations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'operation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Demandes $demandes = null;

    #[ORM\OneToOne(inversedBy: 'operations', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employes $employe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDemandes(): ?Demandes
    {
        return $this->demandes;
    }

    public function setDemandes(?Demandes $demandes): static
    {
        $this->demandes = $demandes;

        return $this;
    }

    public function getEmploye(): ?Employes
    {
        return $this->employe;
    }

    public function setEmploye(Employes $employe): static
    {
        $this->employe = $employe;

        return $this;
    }
}
