<?php

namespace App\Product\Domain;

use App\Shared\Domain\Aggregate;

class Product extends Aggregate
{
    public function __construct(
        private ProductId $id,
        private ProductName $name,
        private ProductPrice $price,
    ) {
    }

    public static function create(
        ProductId $id,
        ProductName $name,
        ProductPrice $price
    ): self {
        return new self($id, $name, $price);
    }

    public function getId(): ProductId
    {
        return $this->id;
    }
    public function getName(): ProductName
    {
        return $this->name;
    }

    public function getPrice(): ProductPrice
    {
        return $this->price;
    }
}
