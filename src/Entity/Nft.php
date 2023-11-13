<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use App\Entity\User;
use App\Repository\NftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NftRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    operations: [
        new Post(),
        new Patch(),
        new Get(),
        new GetCollection(normalizationContext: ['groups' => ['read:collection', 'read:Nft']])
    ]
)]
class Nft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read", "read:collection"])]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Groups(["read", "read:collection"])]
    private ?string $nftName = null;

    #[ORM\Column]
    #[Groups(["read", "read:collection"])]
    private ?\DateTimeImmutable $nftCreationDate = null;

    #[ORM\Column]
    #[Groups(["read", "read:collection"])]
    private ?int $initialPrice = null;

    #[ORM\Column]
    #[Groups(["read", "read:collection"])]
    private ?bool $isAvailable = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(["read", "read:collection"])]
    private ?int $actualPrice = null;

    #[ORM\ManyToOne(inversedBy: 'possess', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read", "read:collection"])]
    private ?NftFlow $nftFlow = null;
    #[Groups(["read", "read:collection"])]

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'have')]
    // #[Groups(["read", "read:collection"])]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'nftImage', targetEntity: Image::class, cascade: ['persist'])]
    #[Groups(["read", "read:collection"])]
    private Collection $nftImage;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "nft_owner_id", referencedColumnName: "id")]
    #[Groups(["read", "read:collection"])]
    private ?User $nftOwner = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->nftCreationDate = new \DateTimeImmutable();
        $this->nftImage = new ArrayCollection();
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

    /**
     * @return Collection<int, Image>
     */
    public function getNftImage(): Collection
    {
        return $this->nftImage;
    }

    public function addNftImage(Image $nftImage): static
    {
        if (!$this->nftImage->contains($nftImage)) {
            $this->nftImage->add($nftImage);
            $nftImage->setNftImage($this);
        }

        return $this;
    }

    public function removeNftImage(Image $nftImage): static
    {
        if ($this->nftImage->removeElement($nftImage)) {
            // set the owning side to null (unless already changed)
            if ($nftImage->getNftImage() === $this) {
                $nftImage->setNftImage(null);
            }
        }
        return $this;
    }
    public function __toString(): string
    {
        $categoryNames = [];
    
        foreach ($this->getCategories() as $category) {
            $categoryNames[] = $category->getName();
        }
    
        return implode(', ', $categoryNames);
    }

    public function getNftOwner(): ?User
    {
        return $this->nftOwner;
    }
    

    public function setNftOwner(?User $nftOwner): self
    {
        $this->nftOwner = $nftOwner;
        return $this;
    }
}