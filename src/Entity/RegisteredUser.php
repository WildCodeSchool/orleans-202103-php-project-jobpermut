<?php

namespace App\Entity;

use App\Repository\RegisteredUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegisteredUserRepository::class)
 */
class RegisteredUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $lastname;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $jobAddress;

    /**
     * @ORM\Column(type="integer")
     */
    private int $ogr;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="registeredUser", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\OneToOne(targetEntity=Subscription::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private Subscription $subscription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $username;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        if ($phone !== null) {
            $this->phone = $phone;
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getJobAddress(): ?string
    {
        return $this->jobAddress;
    }

    public function setJobAddress(string $jobAddress): self
    {
        $this->jobAddress = $jobAddress;

        return $this;
    }

    public function getOgr(): ?int
    {
        return $this->ogr;
    }

    public function setOgr(int $ogr): self
    {
        $this->ogr = $ogr;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): self
    {
        if ($subscription !== null) {
            $this->subscription = $subscription;
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
}