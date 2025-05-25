<?php

namespace App\Product\Application;

use App\Product\Domain\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Entity\Product;

final readonly class UpdateProductUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function execute(string $id, string $name, float $price): bool
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            return false;
        }

        $product->setName($name);
        $product->setPrice($price);

        $this->productRepository->store($product);

        return true;
    }
}
