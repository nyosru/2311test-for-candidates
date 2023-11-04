<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class PriceCalculate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, precision: 10, scale: '0', nullable: true)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: Types::INTEGER, message: 'Поле должно содержать только целые числа ({{ type }}), а сейчас {{ value }}')]
    private ?int $product = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    //    #[Assert\Type( type: Types::INTEGER, message:'Поле должно содержать только целые числа')]
    private ?string $taxNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Type(type: Types::STRING, message: 'Поле должно содержать код купона')]
    private ?string $couponCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type(type: Types::STRING, message: 'Поле должно содержать код купона')]
    private ?string $paymentProcessor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?int
    {
        return $this->product;
    }

    public function setProduct(?int $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(?string $taxNumber): static
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    public function setCouponCode(?string $couponCode): static
    {
        $this->couponCode = $couponCode;

        return $this;
    }

    public function getPaymentProcessor(): ?string
    {
        return $this->paymentProcessor;
    }

    public function setPaymentProcessor(?string $paymentProcessor): static
    {
        $this->paymentProcessor = $paymentProcessor;

        return $this;
    }
}
