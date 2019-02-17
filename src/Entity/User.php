<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\JoinColumn;
use FOS\RestBundle\Controller\Annotations\View;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface{
    /**
     * @Groups("user")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("user")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @Groups("user")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @Groups("user")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @Groups("user")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $apiKey;

    /**
     * @Groups("user")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Groups("user")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @Groups("user")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @Groups("user")
     * @ORM\Column(type="simple_array")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="users")
     */
    private $cards;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subscription", inversedBy="users")
     */
    private $subscription;



    public function __construct()
    {
        $this->roles = array('ROLE_USER');
        $this->apiKey = md5(uniqid());
        $this->createdAt = new \DateTimeImmutable();
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }


    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }
    public function eraseCredentials()
    {
    }
    /**
     * @return Collection|Card[]
     */
    public function setCards($card): self
    {
        $this->addCard($card);
        return $this;
    }
    /** * @View(serializerGroups={"card"}) */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setUsers($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getUsers() === $this) {
                $card->setUsers(null);
            }
        }

        return $this;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }


    /**

     * @return string The password
     */
    public function getPassword()
    {

    }

    /**

     * @return string|null The salt
     */
    public function getSalt()
    {

    }

    /**
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }
}
