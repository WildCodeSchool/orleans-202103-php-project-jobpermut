<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\TextType;
use App\Repository\SubscriptionRepository;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=SubscriptionRepository::class)
 * @Vich\Uploadable
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $curriculum;

    /**
     * @Vich\UploadableField(mapping="curriculum", fileNameProperty="curriculum")
     * @var File|null
     */
    private $curriculumFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $jobDescription;

    /**
     * @Vich\UploadableField(mapping="job_description", fileNameProperty="jobDescription")
     * @var File|null
     */
    private $jobDescriptionFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private DateTimeInterface $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="subscription")
     */
    private $company;

    public function __serialize(): array
    {
        return [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscriptionAt(): ?DateTimeInterface
    {
        return $this->subscriptionAt;
    }

    public function setSubscriptionAt(DateTimeInterface $subscriptionAt): self
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

    public function setCurriculumFile(?File $curriculumFile = null): void
    {
        $this->curriculumFile = $curriculumFile;

        if (null !== $curriculumFile) {
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    public function getCurriculumFile(): ?File
    {
        return $this->curriculumFile;
    }

    public function setjobDescriptionFile(?File $jobDescriptionFile = null): void
    {
        $this->jobDescriptionFile = $jobDescriptionFile;

        if (null !== $jobDescriptionFile) {
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    public function getjobDescriptionFile(): ?File
    {
        return $this->jobDescriptionFile;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
}
