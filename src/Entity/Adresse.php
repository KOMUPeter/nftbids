<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
#[ApiResource(
    operations: [
        new Post(),
        new Patch(),
        new Get(),
        new GetCollection()
    ]
)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)] 
    // #[Groups(['write'])]
    private ?string $line1 = null;

    #[ORM\OneToOne(mappedBy: 'lives', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'located')]
    #[ORM\JoinColumn(nullable: false)]
    // #[Groups(['write'])]
    private ?City $city = null;

    // public function __construct()
    // {
    //     $this->lives = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): static
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        // set the owning side of the relation if necessary
        if ($user->getLives() !== $this) {
            $user->setLives($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getLine1().' '.$this->getCity()->getCityName();
    }
}
