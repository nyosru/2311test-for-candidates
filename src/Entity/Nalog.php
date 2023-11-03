<?php

namespace App\Entity;

use App\Repository\NalogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NalogRepository::class)]
class Nalog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0', nullable: true)]
    private ?int $procent = null;

    #[ORM\Column(length: 5)]
    private ?string $key = null;


    #[ORM\Column(type: Types::STRING)]
    private ?string $filter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;
        return $this;
    }

    public function getProcent(): ?string
    {
        return $this->procent;
    }

    public function setProcent(?string $procent): static
    {
        $this->procent = $procent;
        return $this;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): static
    {
        $this->key = $key;
        return $this;
    }

    public function getFilter(): ?string
    {
        return $this->filter;
    }

    public function setFilter(string $filter): static
    {
        $this->filter = $filter;
        return $this;
    }

}
