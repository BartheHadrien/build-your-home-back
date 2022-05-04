<?php

namespace App\Entity;

use App\Repository\VATRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VATRepository::class)
 */
class VAT
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups("browse_article")
     * @Groups("read_article")
     */
    private $vat_name;

    /**
     * @ORM\Column(type="float")
     * @Groups("browse_article")
     * @Groups("read_article")
     */
    private $vat_rate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $vat_createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $vat_updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="article_vat")
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

    public function getVatName(): ?string
    {
        return $this->vat_name;
    }

    public function setVatName(string $vat_name): self
    {
        $this->vat_name = $vat_name;

        return $this;
    }

    public function getVatRate(): ?float
    {
        return $this->vat_rate;
    }

    public function setVatRate(float $vat_rate): self
    {
        $this->vat_rate = $vat_rate;

        return $this;
    }

    public function getVatCreatedAt(): ?\DateTimeInterface
    {
        return $this->vat_createdAt;
    }

    public function setVatCreatedAt(\DateTimeInterface $vat_createdAt): self
    {
        $this->vat_createdAt = $vat_createdAt;

        return $this;
    }

    public function getVatUpdatedAt(): ?\DateTimeInterface
    {
        return $this->vat_updatedAt;
    }

    public function setVatUpdatedAt(?\DateTimeInterface $vat_updatedAt): self
    {
        $this->vat_updatedAt = $vat_updatedAt;

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
            $article->setArticleVat($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getArticleVat() === $this) {
                $article->setArticleVat(null);
            }
        }

        return $this;
    }
}
