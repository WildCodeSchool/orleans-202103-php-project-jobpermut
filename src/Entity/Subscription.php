<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscriptionRepository::class)
 */
class Subscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $subscriptionAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $curriculum;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $jobDescription;

    /**
     * @ORM\OneToOne(targetEntity=RegisteredUser::class, mappedBy="subscription", cascade={"persist", "remove"})
     */
    private $registeredUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscriptionAt(): ?\DateTimeInterface
    {
        return $this->subscriptionAt;
    }

    public function setSubscriptionAt(\DateTimeInterface $subscriptionAt): self
    {
        $this->subscriptionAt = $subscriptionAt;

        return $this;
    }

    public function getcurriculum(): ?string
    {
        return $this->curriculum;
    }

    public function setcurriculum(string $curriculum): self
    {
        $this->curriculum = $curriculum;

        return $this;
    }

    public function getJobDescription(): ?string
    {
        return $this->jobDescription;
    }

    public function setJobDescription(?string $jobDescription): self
    {
        $this->jobDescription = $jobDescription;

        return $this;
    }

    public function getRegisteredUser(): ?RegisteredUser
    {
        return $this->registeredUser;
    }

    public function setRegisteredUser(?RegisteredUser $registeredUser): self
    {
        // unset the owning side of the relation if necessary
        if ($registeredUser === null && $this->registeredUser !== null) {
            $this->registeredUser->setSubscription(null);
        }

        // set the owning side of the relation if necessary
        if ($registeredUser !== null && $registeredUser->getSubscription() !== $this) {
            $registeredUser->setSubscription($this);
        }

        $this->registeredUser = $registeredUser;

        return $this;
    }
}
