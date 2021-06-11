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
    private string $jobDescription;

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

    public function getJobDescription(): ?string
    {
        return $this->jobDescription;
    }

    public function setJobDescription(?string $jobDescription): self
    {
        if ($jobDescription !== null) {
            $this->jobDescription = $jobDescription;
        }

        return $this;
    }
}
