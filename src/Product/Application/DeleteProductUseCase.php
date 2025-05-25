<?php

namespace App\Product\Application;

use App\Product\Domain\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Entity\Product;

final class DeleteProductUseCase
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    ) {
    }

    public function execute(string $id): bool
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            return false;
        }

        $this->productRepository->delete($product);

        return true;
    }
}
