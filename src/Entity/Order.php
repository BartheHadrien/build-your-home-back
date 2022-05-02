<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $order_ref;

    /**
     * @ORM\Column(type="integer")
     */
    private $order_status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $order_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $order_updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderRef(): ?string
    {
        return $this->order_ref;
    }

    public function setOrderRef(string $order_ref): self
    {
        $this->order_ref = $order_ref;

        return $this;
    }

    public function getOrderStatus(): ?int
    {
        return $this->order_status;
    }

    public function setOrderStatus(int $order_status): self
    {
        $this->order_status = $order_status;

        return $this;
    }

    public function getOrderCreatedAt(): ?\DateTimeInterface
    {
        return $this->order_createdAt;
    }

    public function setOrderCreatedAt(\DateTimeInterface $order_createdAt): self
    {
        $this->order_createdAt = $order_createdAt;

        return $this;
    }

    public function getOrderUpdatedAt(): ?\DateTimeInterface
    {
        return $this->order_updatedAt;
    }

    public function setOrderUpdatedAt(?\DateTimeInterface $order_updatedAt): self
    {
        $this->order_updatedAt = $order_updatedAt;

        return $this;
    }
}
