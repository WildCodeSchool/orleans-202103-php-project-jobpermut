<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Cet email est déjà utilisé. Veuillez en essayer un autre.")
 * @UniqueEntity(fields={"username"}, message="Ce pseudonyme est déjà utilisé. Veuillez en essayer un autre.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotNull
     * @Assert\NotBlank()
     * @Assert\Length(max=180)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\OneToOne(targetEntity=RegisteredUser::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private ?RegisteredUser $registeredUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $username;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isVisible = true;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="user")
     */
    private ?Company $company;

    /**
     * @ORM\OneToMany(targetEntity=Testimony::class, mappedBy="user")
     */
    private Collection $testimonies;

    /**
     * @ORM\OneToMany(targetEntity=UserLike::class, mappedBy="userLiker")
     */
    private Collection $userLikes;

    /**
     * @ORM\OneToMany(targetEntity=UserLike::class, mappedBy="userLiked")
     */
    private Collection $userLikedBy;

    public function __construct()
    {
        $this->testimonies = new ArrayCollection();
        $this->userLikes = new ArrayCollection();
        $this->userLikedBy = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(string $roles): self
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRegisteredUser(): ?RegisteredUser
    {
        return $this->registeredUser;
    }

    public function setRegisteredUser(RegisteredUser $registeredUser): self
    {
        // set the owning side of the relation if necessary
        if ($registeredUser->getUser() !== $this) {
            $registeredUser->setUser($this);
        }

        $this->registeredUser = $registeredUser;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|Testimony[]
     */
    public function getTestimonies(): Collection
    {
        return $this->testimonies;
    }

    public function addTestimony(Testimony $testimony): self
    {
        if (!$this->testimonies->contains($testimony)) {
            $this->testimonies[] = $testimony;
            $testimony->setUser($this);
        }

        return $this;
    }

    public function removeTestimony(Testimony $testimony): self
    {
        if ($this->testimonies->removeElement($testimony)) {
            // set the owning side to null (unless already changed)
            if ($testimony->getUser() === $this) {
                $testimony->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of isVisible
     */
    public function getIsVisible(): bool
    {
        return $this->isVisible;
    }

    /**
     * Set the value of isVisible
     */
    public function setIsVisible(bool $isVisible): void
    {
        $this->isVisible = $isVisible;
    }

    /**
     * @return Collection|UserLike[]
     */
    public function getUserLikes(): Collection
    {
        return $this->userLikes;
    }

    public function getOneUserLike(User $user): bool
    {
        foreach ($this->getUserLikes() as $userLike) {
            if ($userLike->getUserLiked() === $user) {
                return true;
            }
        }

        return false;
    }

    public function addUserLike(UserLike $userLike): self
    {
        if (!$this->userLikes->contains($userLike)) {
            $this->userLikes[] = $userLike;
            $userLike->setUserLiker($this);
        }

        return $this;
    }

    public function removeUserLike(UserLike $userLike): self
    {
        if ($this->userLikes->removeElement($userLike)) {
            // set the owning side to null (unless already changed)
            if ($userLike->getUserLiker() === $this) {
                $userLike->setUserLiker(null);
            }
        }

        return $this;
    }

    public function isInUserLikeList(UserLike $userLike): bool
    {
        return $this->getUserLikes()->contains($userLike) ? true : false;
    }

    /**
     * @return Collection|UserLike[]
     */
    public function getUserLikedBy(): Collection
    {
        return $this->userLikedBy;
    }

    public function addLikedBy(UserLike $userLikedBy): self
    {
        if (!$this->userLikedBy->contains($userLikedBy)) {
            $this->userLikedBy[] = $userLikedBy;
            $userLikedBy->setUserLiked($this);
        }

        return $this;
    }

    public function removeLikedBy(UserLike $userLikedBy): self
    {
        if ($this->userLikedBy->removeElement($userLikedBy)) {
            // set the owning side to null (unless already changed)
            if ($userLikedBy->getUserLiked() === $this) {
                $userLikedBy->setUserLiked(null);
            }
        }

        return $this;
    }
}
