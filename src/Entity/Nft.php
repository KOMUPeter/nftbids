<?php

namespace App\Entity;

use App\Repository\NftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NftRepository::class)]
class Nft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $nftName = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $nftCreationDate = null;

    #[ORM\Column]
    private ?int $initialPrice = null;

    #[ORM\Column]
    private ?bool $isAvailable = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $actualPrice = null;

    #[ORM\ManyToOne(inversedBy: 'possess')]
    #[ORM\JoinColumn(nullable: false)]
    private ?NftFlow $nftFlow = null;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'have')]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->nftCreationDate = new \DateTimeImmutable();
    }
 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNftName(): ?string
    {
        return $this->nftName;
    }

    public function setNftName(string $nftName): static
    {
        $this->nftName = $nftName;

        return $this;
    }

    public function getNftCreationDate(): ?\DateTimeImmutable
    {
        return $this->nftCreationDate;
    }

    public function setNftCreationDate(\DateTimeImmutable $nftCreationDate): static
    {
        $this->nftCreationDate = $nftCreationDate;

        return $this;
    }

    public function getInitialPrice(): ?int
    {
        return $this->initialPrice;
    }

    public function setInitialPrice(int $initialPrice): static
    {
        $this->initialPrice = $initialPrice;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getActualPrice(): ?int
    {
        return $this->actualPrice;
    }

    public function setActualPrice(int $actualPrice): static
    {
        $this->actualPrice = $actualPrice;

        return $this;
    }

    public function getNftFlow(): ?NftFlow
    {
        return $this->nftFlow;
    }

    public function setNftFlow(?NftFlow $nftFlow): static
    {
        $this->nftFlow = $nftFlow;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addHave($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeHave($this);
        }

        return $this;
    }
}