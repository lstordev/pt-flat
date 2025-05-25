<?php

namespace App\Product\Application;

use App\Product\Domain\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Entity\Product;

final class GetProductByIdUseCase
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    ) {
    }

    public function execute(string $id): ?Product
    {
        return $this->productRepository->find($id);
    }
}
