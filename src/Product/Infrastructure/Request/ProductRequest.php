<?php

namespace App\Product\Infrastructure\Request;

use Symfony\Component\Validator\Constraints as Assert;

class ProductRequest
{
    #[Assert\NotBlank, Assert\Length(min: 3, max: 100)]
    public string $name;

    #[Assert\NotBlank, Assert\GreaterThan(value: 0)]
    public float $price;
}
