<?php

namespace App\Tests\Unit\Product\Application;

use App\Product\Application\UpdateProductUseCase;
use App\Product\Domain\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Entity\Product;
use PHPUnit\Framework\TestCase;

class UpdateProductUseCaseTest extends TestCase
{
    public function testExecuteUpdatesProductWhenFound(): void
    {
        $productId = '123';
        $name = 'Updated Product';
        $price = 20.0;

        $existingProduct = new Product();
        $existingProduct->setName('Original Product');
        $existingProduct->setPrice(10.0);

        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $productRepository->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn($existingProduct);

        $productRepository->expects($this->once())
            ->method('store')
            ->with($this->callback(function (Product $product) use ($name, $price) {
                return $product->getName() === $name &&
                       $product->getPrice() === $price;
            }));

        $useCase = new UpdateProductUseCase($productRepository);

        $result = $useCase->execute($productId, $name, $price);

        $this->assertTrue($result);
    }

    public function testExecuteReturnsNullWhenProductNotFound(): void
    {
        $productId = '123';
        $name = 'Updated Product';
        $price = 20.0;

        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $productRepository->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn(null);

        $productRepository->expects($this->never())
            ->method('store');

        $useCase = new UpdateProductUseCase($productRepository);

        $result = $useCase->execute($productId, $name, $price);

        $this->assertFalse($result);
    }
}
