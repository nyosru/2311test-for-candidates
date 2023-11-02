<?php
//
//namespace App\Entity\1;
//
//use App\Repository\ProductRepository;
//use Doctrine\DBAL\Types\Types;
//use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;
//
//#[ORM\Entity(repositoryClass: ProductRepository::class)]
//class Product
//{
//    #[ORM\Id]
//    #[ORM\GeneratedValue]
//    #[ORM\Column]
//    private ?int $id = null;
//
//    #[ORM\Column(length: 255)]
//    #[Assert\NotBlank]
//    private ?string $name = null;
//
//    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
//    #[Assert\NotBlank]
//    private ?string $price = null;
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getName(): ?string
//    {
//        return $this->name;
//    }
//
//    public function setName(string $name): static
//    {
//        $this->name = $name;
//
//        return $this;
//    }
//
//    public function getPrice(): ?string
//    {
//        return $this->price;
//    }
//
//    public function setPrice(string $price): static
//    {
//        $this->price = $price;
//
//        return $this;
//    }
//}
