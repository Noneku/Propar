<?php

namespace App\Entity;

use App\Repository\DemandesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandesRepository::class)]
class Demandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_demande = null;

    #[ORM\OneToOne(inversedBy: 'demande', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prestations $prestation = null;
    

    #[ORM\OneToOne(inversedBy: 'demandes', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clients $client = null;

    #[ORM\OneToMany(mappedBy: 'demandes', targetEntity: Operations::class)]
    private Collection $operation;

    public function __construct()
    {
        $this->operation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->date_demande;
    }

    public function setDateDemande(\DateTimeInterface $date_demande): static
    {
        $this->date_demande = $date_demande;

        return $this;
    }

    public function getPrestation(): ?Prestations
    {
        return $this->prestation;
    }

    public function setPrestation(Prestations $prestation): static
    {
        $this->prestation = $prestation;

        return $this;
    }

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(Clients $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Operations>
     */
    public function getOperation(): Collection
    {
        return $this->operation;
    }

    public function addOperation(Operations $operation): static
    {
        if (!$this->operation->contains($operation)) {
            $this->operation->add($operation);
            $operation->setDemandes($this);
        }

        return $this;
    }

    public function removeOperation(Operations $operation): static
    {
        if ($this->operation->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getDemandes() === $this) {
                $operation->setDemandes(null);
            }
        }

        return $this;
    }
}
