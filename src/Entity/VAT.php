<?php

namespace App\Entity;

use App\Repository\VATRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VATRepository::class)
 */
class VAT
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups("browse_vat")
     * @Groups("read_vat")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("browse_vat")
     * @Groups("read_vat")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     * 
     * @Assert\NotBlank
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * 
     * @Groups("browse_article")
     * @Groups("read_article")
     * @Groups("browse_vat")
     * @Groups("read_vat")
     * @Groups("read_category_article")
     * @Groups("browse_order")
     * @Groups("read_order")
     * 
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $rate;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("browse_vat")
     * @Groups("read_vat")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Groups("browse_vat")
     * @Groups("read_vat")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="vat")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setVat($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getVat() === $this) {
                $article->setVat(null);
            }
        }

        return $this;
    }
}
