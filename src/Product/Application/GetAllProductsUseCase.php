<?php

namespace App\Product\Application;

use App\Product\Domain\ProductRepositoryInterface;

final class GetAllProductsUseCase
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    ) {
    }

    public function execute(): array
    {
        return $this->productRepository->findAll();
    }
}
