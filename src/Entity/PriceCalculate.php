<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
//
//    #[ORM\Column(type: Types::INTEGER, precision: 10, scale: '0', nullable: true)]
//    #[Assert\NotBlank]
//    #[Assert\NotNull]
//    #[Assert\Type(type: Types::INTEGER, message: 'Поле должно содержать только целые числа ({{ type }}), а сейчас {{ value }}')]
//    private ?int $product = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    //    #[Assert\Type( type: Types::INTEGER, message:'Поле должно содержать только целые числа')]
    private ?string $taxNumber = null;


    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type(type: Types::STRING, message: 'Поле должно содержать код купона')]
    private ?string $paymentProcessor = null;

    #[ORM\ManyToOne(inversedBy: 'priceCalculates')]
    #[ORM\JoinColumn(nullable: false)]
//    #[Assert\Type(type: Types::INTEGER, message: 'Поле должно быть цифрой')]
    private ?Product $product = null;

//    #[ORM\OneToMany(mappedBy: 'priceCalculate', targetEntity: Coupon::class)]
//    private Collection $cupon;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Coupon $cupon = null;

    public function __construct()
    {
//        $this->cupon = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getCupon(): ?Coupon
    {
        return $this->cupon;
    }

    public function setCupon(?Coupon $cupon): static
    {
        $this->cupon = $cupon;

        return $this;
    }
}
