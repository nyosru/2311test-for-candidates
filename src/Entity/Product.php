<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;


    public function __construct()
    {
        $this->priceCalculates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, PriceCalculate>
     */
    public function getPriceCalculates(): Collection
    {
        return $this->priceCalculates;
    }

    public function addPriceCalculate(PriceCalculate $priceCalculate): static
    {
        if (!$this->priceCalculates->contains($priceCalculate)) {
            $this->priceCalculates->add($priceCalculate);
            $priceCalculate->setProduct($this);
        }

        return $this;
    }

    public function removePriceCalculate(PriceCalculate $priceCalculate): static
    {
        if ($this->priceCalculates->removeElement($priceCalculate)) {
            // set the owning side to null (unless already changed)
            if ($priceCalculate->getProduct() === $this) {
                $priceCalculate->setProduct(null);
            }
        }

        return $this;
    }
}
