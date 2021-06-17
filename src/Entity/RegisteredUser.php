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
    private string $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $cityJob;

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
    private string $street;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\JoinColumn(nullable=true)
     */
    private string $streetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $jobStreet;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\JoinColumn(nullable=true)
     */
    private string $jobStreetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $jobZipcode;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCityJob(): ?string
    {
        return $this->cityJob;
    }

    public function setCityJob(string $cityJob): self
    {
        $this->cityJob = $cityJob;

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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getJobStreet(): ?string
    {
        return $this->jobStreet;
    }

    public function setJobStreet(string $jobStreet): self
    {
        $this->jobStreet = $jobStreet;

        return $this;
    }

    public function getJobStreetNumber(): ?string
    {
        return $this->jobStreetNumber;
    }

    public function setJobStreetNumber(string $jobStreetNumber): self
    {
        $this->jobStreetNumber = $jobStreetNumber;

        return $this;
    }

    public function getJobZipcode(): ?string
    {
        return $this->jobZipcode;
    }

    public function setJobZipcode(string $jobZipcode): self
    {
        $this->jobZipcode = $jobZipcode;

        return $this;
    }
}
