<?php

namespace App\Tests\Unit\Product\Application;

use App\Product\Application\CreateProductUseCase;
use App\Product\Domain\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Entity\Product;
use PHPUnit\Framework\TestCase;

class CreateProductUseCaseTest extends TestCase
{
    public function testExecuteCreatesAndStoresProduct(): void
    {
        $name = 'Test Product';
        $price = 10.0;

        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $productRepository->expects($this->once())
            ->method('store')
            ->with($this->callback(function (Product $product) use ($name, $price) {
                return $product->getName() === $name &&
                       $product->getPrice() === $price;
            }));

        $useCase = new CreateProductUseCase($productRepository);

        $useCase->execute($name, $price);
    }
}
