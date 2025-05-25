<?php

namespace App\Product\Application;

use App\Product\Domain\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Entity\Product;

final readonly class GetProductByIdUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function execute(string $id): ?Product
    {
        return $this->productRepository->find($id);
    }
}
