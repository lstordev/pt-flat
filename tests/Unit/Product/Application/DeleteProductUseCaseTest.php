<?php

namespace App\Tests\Unit\Product\Application;

use App\Product\Application\DeleteProductUseCase;
use App\Product\Domain\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Entity\Product;
use PHPUnit\Framework\TestCase;

class DeleteProductUseCaseTest extends TestCase
{
    public function testExecuteDeletesProductWhenFound(): void
    {
        $productId = '123';
        $product = new Product();

        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $productRepository->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn($product);

        $productRepository->expects($this->once())
            ->method('delete')
            ->with($product);

        $useCase = new DeleteProductUseCase($productRepository);

        $result = $useCase->execute($productId);

        $this->assertTrue($result);
    }

    public function testExecuteReturnsFalseWhenProductNotFound(): void
    {
        $productId = '123';

        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $productRepository->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn(null);

        $productRepository->expects($this->never())
            ->method('delete');

        $useCase = new DeleteProductUseCase($productRepository);

        $result = $useCase->execute($productId);

        $this->assertFalse($result);
    }
}
