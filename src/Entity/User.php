<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource()]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    protected ?string $password = null;
    protected ?string $plainPassword = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    // to chose between male and female
    #[ORM\Column(length: 50)]
    /**
     * @Assert\Choice(choices={"male", "female"})
     */
    private ?string $gender = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adresse $lives = null;

    #[ORM\Column(length: 60)]
    private ?string $lastName = null;

    // #[ORM\OneToMany(mappedBy: 'nftOwner', targetEntity: nft::class)]
    // private Collection $nftOwner;

    #[Groups(["read"])] // Include this property only in the "read" serialization group
    #[ORM\OneToMany(mappedBy: 'nftOwner', targetEntity: nft::class)]
    private Collection $nftOwner;

    public function __construct()
    {
        $this->lives = new Adresse();
        $this->nftOwner = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guaranted every user has at least ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getLives(): ?Adresse
    {
        return $this->lives;
    }

    public function setLives(Adresse $lives): static
    {
        $this->lives = $lives;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }


    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    //   public function __toString(): string
    //   {
    //       return $this->gender; // Return a string representation of the User entity
    //   }

    /**
     * @return Collection<int, nft>
     */
    public function getNftOwner(): Collection
    {
        return $this->nftOwner;
    }

    public function addNftOwner(nft $nftOwner): static
    {
        if (!$this->nftOwner->contains($nftOwner)) {
            $this->nftOwner->add($nftOwner);
            $nftOwner->setNftOwner($this);
        }

        return $this;
    }

    public function removeNftOwner(nft $nftOwner): static
    {
        if ($this->nftOwner->removeElement($nftOwner)) {
            // set the owning side to null (unless already changed)
            if ($nftOwner->getNftOwner() === $this) {
                $nftOwner->setNftOwner(null);
            }
        }

        return $this;
    }
}