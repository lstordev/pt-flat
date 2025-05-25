<?php

namespace App\Tests\Unit\Product\Application;

use App\Product\Application\GetAllProductsUseCase;
use App\Product\Domain\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Entity\Product;
use PHPUnit\Framework\TestCase;

class GetAllProductsUseCaseTest extends TestCase
{
    public function testExecuteReturnsAllProducts(): void
    {
        $product1 = new Product();
        $product1->setName('Product 1');
        $product1->setPrice(10.0);

        $product2 = new Product();
        $product2->setName('Product 2');
        $product2->setPrice(20.0);

        $expectedProducts = [$product1, $product2];

        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $productRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($expectedProducts);

        $useCase = new GetAllProductsUseCase($productRepository);

        $result = $useCase->execute();

        $this->assertSame($expectedProducts, $result);
    }
}
