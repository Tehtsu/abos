<?php

namespace App\Entity;

use App\Repository\SubscriptionEntityRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SubscriptionEntityRepository::class)]
class SubscriptionEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string",length: 255)]
    #[Assert\NotBlank()]
    private string $name;

    #[ORM\Column(type: 'date')]
    private DateTime $startDate;

    #[ORM\ManyToOne(targetEntity: PaymentTypeEntity::class, inversedBy: 'subscriptions')]
    private ?PaymentTypeEntity $paymentType;

    #[ORM\Column(type: 'float', nullable: true)]
    private $coasts;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $paymentPeriod;

    #[ORM\ManyToOne(targetEntity: CategoryEntity::class)]
    private ?CategoryEntity $category;

    #[ORM\ManyToOne(inversedBy: 'subscriptionEntities')]
    private ?User $user = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(DateTime $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return PaymentTypeEntity|null
     */
    public function getPaymentType(): ?PaymentTypeEntity
    {
        return $this->paymentType;
    }

    /**
     * @param PaymentTypeEntity|null $paymentType
     * @return $this
     */
    public function setPaymentType(?PaymentTypeEntity $paymentType): self
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    public function getCoasts(): float
    {
        return $this->coasts;
    }

    public function setCoasts(?float $coasts): self
    {
        $this->coasts = $coasts;
        return $this;
    }

    public function getPaymentPeriod(): int
    {
        return $this->paymentPeriod;
    }

    public function setPaymentPeriod(int $paymentPeriod): self
    {
        $this->paymentPeriod = $paymentPeriod;
        return $this;
    }

    public function getCategory(): ?CategoryEntity
    {
        return $this->category;
    }

    public function setCategory(?CategoryEntity $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }


}
