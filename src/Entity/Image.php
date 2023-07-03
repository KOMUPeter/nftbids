<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $imageName = null;

    #[ORM\Column(length: 255)]
    private ?string $imageLink = null;

    #[ORM\ManyToOne(inversedBy: 'nftImage')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nft $nftImage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setImageLink(string $imageLink): static
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    public function getNftImage(): ?Nft
    {
        return $this->nftImage;
    }

    public function setNftImage(?Nft $nftImage): static
    {
        $this->nftImage = $nftImage;

        return $this;
    }
}
