<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
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
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: SubscriptionEntity::class)]
    private Collection $subscriptionEntities;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CategoryEntity::class)]
    private Collection $categoryEntities;

    public function __construct()
    {
        $this->subscriptionEntities = new ArrayCollection();
        $this->categoryEntities = new ArrayCollection();
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
        // guarantee every user at least has ROLE_USER
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
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, SubscriptionEntity>
     */
    public function getSubscriptionEntities(): Collection
    {
        return $this->subscriptionEntities;
    }

    public function addSubscriptionEntity(SubscriptionEntity $subscriptionEntity): static
    {
        if (!$this->subscriptionEntities->contains($subscriptionEntity)) {
            $this->subscriptionEntities->add($subscriptionEntity);
            $subscriptionEntity->setUser($this);
        }

        return $this;
    }

    public function removeSubscriptionEntity(SubscriptionEntity $subscriptionEntity): static
    {
        if ($this->subscriptionEntities->removeElement($subscriptionEntity)) {
            // set the owning side to null (unless already changed)
            if ($subscriptionEntity->getUser() === $this) {
                $subscriptionEntity->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategoryEntity>
     */
    public function getCategoryEntities(): Collection
    {
        return $this->categoryEntities;
    }

    public function addCategoryEntity(CategoryEntity $categoryEntity): static
    {
        if (!$this->categoryEntities->contains($categoryEntity)) {
            $this->categoryEntities->add($categoryEntity);
            $categoryEntity->setUser($this);
        }

        return $this;
    }

    public function removeCategoryEntity(CategoryEntity $categoryEntity): static
    {
        if ($this->categoryEntities->removeElement($categoryEntity)) {
            // set the owning side to null (unless already changed)
            if ($categoryEntity->getUser() === $this) {
                $categoryEntity->setUser(null);
            }
        }

        return $this;
    }
}
