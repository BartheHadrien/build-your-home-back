<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $user_lastname;

    /**
     * @ORM\Column(type="string", length=30)
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $user_firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $user_adress;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $user_birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_password;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $user_role;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $user_mail;

    /**
     * @ORM\Column(type="string", length=20)
     * 
     * @Groups("readUser")
     * @Groups("browse_order")
     * @Groups("read_order")
     */
    private $user_phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $user_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $user_updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="order_user")
     * @Groups("readUser")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=Favorite::class, mappedBy="favorite_user")
     * @Groups("readUser")
     */
    private $favorites;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="comment_user")
     * @Groups("readUser")
     */
    private $comments;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserLastname(): ?string
    {
        return $this->user_lastname;
    }

    public function setUserLastname(string $user_lastname): self
    {
        $this->user_lastname = $user_lastname;

        return $this;
    }

    public function getUserFirstname(): ?string
    {
        return $this->user_firstname;
    }

    public function setUserFirstname(string $user_firstname): self
    {
        $this->user_firstname = $user_firstname;

        return $this;
    }

    public function getUserAdress(): ?string
    {
        return $this->user_adress;
    }

    public function setUserAdress(string $user_adress): self
    {
        $this->user_adress = $user_adress;

        return $this;
    }

    public function getUserBirthdate(): ?\DateTimeInterface
    {
        return $this->user_birthdate;
    }

    public function setUserBirthdate(\DateTimeInterface $user_birthdate): self
    {
        $this->user_birthdate = $user_birthdate;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->user_password;
    }

    public function setUserPassword(string $user_password): self
    {
        $this->user_password = $user_password;

        return $this;
    }

    public function getUserRole(): ?string
    {
        return $this->user_role;
    }

    public function setUserRole(string $user_role): self
    {
        $this->user_role = $user_role;

        return $this;
    }

    public function getUserMail(): ?string
    {
        return $this->user_mail;
    }

    public function setUserMail(string $user_mail): self
    {
        $this->user_mail = $user_mail;

        return $this;
    }

    public function getUserPhone(): ?string
    {
        return $this->user_phone;
    }

    public function setUserPhone(string $user_phone): self
    {
        $this->user_phone = $user_phone;

        return $this;
    }

    public function getUserCreatedAt(): ?\DateTimeInterface
    {
        return $this->user_createdAt;
    }

    public function setUserCreatedAt(\DateTimeInterface $user_createdAt): self
    {
        $this->user_createdAt = $user_createdAt;

        return $this;
    }

    public function getUserUpdatedAt(): ?\DateTimeInterface
    {
        return $this->user_updatedAt;
    }

    public function setUserUpdatedAt(?\DateTimeInterface $user_updatedAt): self
    {
        $this->user_updatedAt = $user_updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setOrderUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getOrderUser() === $this) {
                $order->setOrderUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setFavoriteUser($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getFavoriteUser() === $this) {
                $favorite->setFavoriteUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setCommentUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCommentUser() === $this) {
                $comment->setCommentUser(null);
            }
        }

        return $this;
    }
}
