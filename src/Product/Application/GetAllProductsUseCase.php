<?php

namespace App\Product\Application;

use App\Product\Domain\ProductRepositoryInterface;

final readonly class GetAllProductsUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function execute(): array
    {
        return $this->productRepository->findAll();
    }
}
