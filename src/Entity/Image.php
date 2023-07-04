<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\DateTime;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[Vich\Uploadable]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\ManyToOne(inversedBy: 'nftImage')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nft $nftImage = null;

    // NOTE: This is not a mapped field of entity matadata, just a simple property
    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'path')]
    protected ?File $file;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File|UploadedFile|null $file): image
    {
        $this->file = $file;
        $this->setUpdatedAt(new \DateTimeImmutable());

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return 
     */
    public function getNftImage(): ?Nft
    {
        return $this->nftImage;
    }

    /**
     * @param  $nftImage 
     * @return self
     */
    public function setNftImage(?Nft $nftImage): self
    {
        $this->nftImage = $nftImage;
        return $this;
    }
}