<?php

namespace App\Entity;

use App\Repository\CouponRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $kod = null;

    #[ORM\Column(nullable: true)]
    private ?float $sk_fix = null;

    #[ORM\Column(nullable: true)]
    private ?int $sk_proc = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKod(): ?string
    {
        return $this->kod;
    }

    public function setKod(string $kod): static
    {
        $this->kod = $kod;

        return $this;
    }

    public function getSkidkaFix(): ?string
    {
        return $this->skidka_fix;
    }

    public function setSkidkaFix(?string $skidka_fix): static
    {
        $this->skidka_fix = $skidka_fix;

        return $this;
    }

    public function getSkFix(): ?float
    {
        return $this->sk_fix;
    }

    public function setSkFix(?float $sk_fix): static
    {
        $this->sk_fix = $sk_fix;

        return $this;
    }

    public function getSkProc(): ?int
    {
        return $this->sk_proc;
    }

    public function setSkProc(?int $sk_proc): static
    {
        $this->sk_proc = $sk_proc;

        return $this;
    }

    public function getPriceCalculate(): ?PriceCalculate
    {
        return $this->priceCalculate;
    }

    public function setPriceCalculate(?PriceCalculate $priceCalculate): static
    {
        $this->priceCalculate = $priceCalculate;

        return $this;
    }
}
