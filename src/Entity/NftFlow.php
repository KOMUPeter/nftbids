<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\NftFlowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NftFlowRepository::class)]
#[ApiResource()]
class NftFlow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateOfFlow = null;

    #[ORM\Column]
    private ?int $ethValue = null;

    #[ORM\OneToMany(mappedBy: 'nftFlow', targetEntity: Nft::class)]
    private Collection $possess;

    #[ORM\ManyToOne(inversedBy: 'nftFlows')]
    private ?User $user = null;

    public function __construct()
    {
        $this->possess = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOfFlow(): ?\DateTimeImmutable
    {
        return $this->dateOfFlow;
    }

    public function setDateOfFlow(\DateTimeImmutable $dateOfFlow): static
    {
        $this->dateOfFlow = $dateOfFlow;

        return $this;
    }

    public function getEthValue(): ?int
    {
        return $this->ethValue;
    }

    public function setEthValue(int $ethValue): static
    {
        $this->ethValue = $ethValue;

        return $this;
    }

    /**
     * @return Collection<int, Nft>
     */
    public function getPossess(): Collection
    {
        return $this->possess;
    }

    public function addPossess(Nft $possess): static
    {
        if (!$this->possess->contains($possess)) {
            $this->possess->add($possess);
            $possess->setNftFlow($this);
        }

        return $this;
    }

    public function removePossess(Nft $possess): static
    {
        if ($this->possess->removeElement($possess)) {
            // set the owning side to null (unless already changed)
            if ($possess->getNftFlow() === $this) {
                $possess->setNftFlow(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
