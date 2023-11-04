<?php

namespace App\Entity;

use App\Repository\NalogiRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NalogiRepository::class)]
class Nalogi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $country = null;

    #[ORM\Column(length: 2)]
    private ?string $co_key = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $procent = null;

    #[ORM\Column(length: 50, nullable: true)]
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

    public function getCoKey(): ?string
    {
        return $this->co_key;
    }

    public function setCoKey(string $co_key): static
    {
        $this->co_key = $co_key;

        return $this;
    }

    public function getProcent(): ?int
    {
        return $this->procent;
    }

    public function setProcent(?int $procent): static
    {
        $this->procent = $procent;

        return $this;
    }

    public function getFilter(): ?string
    {
        return $this->filter;
    }

    public function setFilter(?string $filter): static
    {
        $this->filter = $filter;

        return $this;
    }
}
