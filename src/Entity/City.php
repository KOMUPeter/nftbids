<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $cityName = null;

    #[ORM\Column]
    private ?int $postalCode = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Adresse::class)]
    private Collection $located;

    public function __construct()
    {
        $this->located = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): static
    {
        $this->cityName = $cityName;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return Collection<int, Adresse>
     */
    public function getLocated(): Collection
    {
        return $this->located;
    }

    public function addLocated(Adresse $located): static
    {
        if (!$this->located->contains($located)) {
            $this->located->add($located);
            $located->setCity($this);
        }

        return $this;
    }

    public function removeLocated(Adresse $located): static
    {
        if ($this->located->removeElement($located)) {
            // set the owning side to null (unless already changed)
            if ($located->getCity() === $this) {
                $located->setCity(null);
            }
        }

        return $this;
    }
}
