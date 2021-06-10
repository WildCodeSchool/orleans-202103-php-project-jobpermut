<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\TextType;
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
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $subscriptionAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $curriculum;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private TextType $jobDescription;

    /**
     * @ORM\OneToOne(targetEntity=RegisteredUser::class, mappedBy="subscription", cascade={"persist", "remove"})
     */
    private RegisteredUser $registeredUser;

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

    public function getCurriculum(): ?string
    {
        return $this->curriculum;
    }

    public function setCurriculum(string $curriculum): self
    {
        $this->curriculum = $curriculum;

        return $this;
    }

    public function getJobDescription(): ?TextType
    {
        return $this->jobDescription;
    }

    public function setJobDescription(?TextType $jobDescription): self
    {
        if ($jobDescription !== null) {
            $this->jobDescription = $jobDescription;
        }

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

        if ($registeredUser !== null) {
            $this->registeredUser = $registeredUser;
        }

        return $this;
    }
}
