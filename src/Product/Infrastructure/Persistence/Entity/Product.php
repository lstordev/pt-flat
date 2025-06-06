<?php

namespace App\Product\Infrastructure\Persistence\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity, ORM\Table(name: 'product')]
class Product
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank, Assert\Length(min: 3)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    public function __construct()
    {
        $this->setCreatedAt(new DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
