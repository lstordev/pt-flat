<?php

namespace App\Product\Domain;

use App\Product\Infrastructure\Persistence\Entity\Product;

interface ProductRepositoryInterface
{
    public function store(Product $product): void;

    public function save(Product $product): void;

    public function find(string $id): ?Product;

    public function findAll(): array;

    public function delete(Product $product): void;
}
