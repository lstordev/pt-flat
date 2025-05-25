<?php

namespace App\Tests\Unit\Product\Application;

use App\Product\Application\GetProductByIdUseCase;
use App\Product\Domain\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Entity\Product;
use PHPUnit\Framework\TestCase;

class GetProductByIdUseCaseTest extends TestCase
{
    public function testExecuteReturnsProductWhenFound(): void
    {
        $productId = '123';
        $expectedProduct = new Product();
        $expectedProduct->setName('Test Product');
        $expectedProduct->setPrice(10.0);

        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $productRepository->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn($expectedProduct);

        $useCase = new GetProductByIdUseCase($productRepository);

        $result = $useCase->execute($productId);

        $this->assertSame($expectedProduct, $result);
    }

    public function testExecuteReturnsNullWhenProductNotFound(): void
    {
        $productId = '123';

        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $productRepository->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn(null);

        $useCase = new GetProductByIdUseCase($productRepository);

        $result = $useCase->execute($productId);

        $this->assertNull($result);
    }
}
