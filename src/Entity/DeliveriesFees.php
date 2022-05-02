<?php

namespace App\Entity;

use App\Repository\DeliveriesFeesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveriesFeesRepository::class)
 */
class DeliveriesFees
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $delivery_fees_name;

    /**
     * @ORM\Column(type="float")
     */
    private $delivery_fees_price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $delivery_fees_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $delivery_fees_updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeliveryFeesName(): ?string
    {
        return $this->delivery_fees_name;
    }

    public function setDeliveryFeesName(string $delivery_fees_name): self
    {
        $this->delivery_fees_name = $delivery_fees_name;

        return $this;
    }

    public function getDeliveryFeesPrice(): ?float
    {
        return $this->delivery_fees_price;
    }

    public function setDeliveryFeesPrice(float $delivery_fees_price): self
    {
        $this->delivery_fees_price = $delivery_fees_price;

        return $this;
    }

    public function getDeliveryFeesCreatedAt(): ?\DateTimeInterface
    {
        return $this->delivery_fees_createdAt;
    }

    public function setDeliveryFeesCreatedAt(\DateTimeInterface $delivery_fees_createdAt): self
    {
        $this->delivery_fees_createdAt = $delivery_fees_createdAt;

        return $this;
    }

    public function getDeliveryFeesUpdatedAt(): ?\DateTimeInterface
    {
        return $this->delivery_fees_updatedAt;
    }

    public function setDeliveryFeesUpdatedAt(?\DateTimeInterface $delivery_fees_updatedAt): self
    {
        $this->delivery_fees_updatedAt = $delivery_fees_updatedAt;

        return $this;
    }
}
