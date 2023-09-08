<?php

namespace App\Entity;

use App\Repository\PaymentTypeEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaymentTypeEntityRepository::class)]
class PaymentTypeEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $description;

    #[ORM\OneToMany(mappedBy: 'paymentType', targetEntity: SubscriptionEntity::class)]
    private $subscriptions;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection<int, SubscriptionEntity>
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(SubscriptionEntity $subscriptionEntity): self
    {
        if (!$this->subscriptions->contains($subscriptionEntity)) {
            $this->subscriptions[] = $subscriptionEntity;
            $subscriptionEntity->setPaymentType($this);
        }
        return $this;
    }

    public function removeSubscription(SubscriptionEntity $subscriptionEntity): self
    {
        if ($this->subscriptions->removeElement($subscriptionEntity)){
            // set the owning side to null (unless already changed)
            if ($subscriptionEntity->getPaymentType() === $this){
                $subscriptionEntity->setPaymentType(null);
            }
        }
        return $this;
    }

}
