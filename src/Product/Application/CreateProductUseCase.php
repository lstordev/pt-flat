<?php

namespace App\Product\Application;

use App\Product\Domain\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Entity\Product;

final class CreateProductUseCase
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    ) {
    }

    public function execute(string $name, float $price): void
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);

        $this->productRepository->store($product);
    }
}
