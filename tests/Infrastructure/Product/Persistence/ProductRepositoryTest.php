<?php

namespace App\Tests\Infrastructure\Product\Persistence;

use App\Product\Infrastructure\Persistence\Entity\Product;
use App\Product\Infrastructure\Persistence\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class ProductRepositoryTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $doctrineRepository;
    private ProductRepository $productRepository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->doctrineRepository = $this->createMock(EntityRepository::class);

        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->with(Product::class)
            ->willReturn($this->doctrineRepository);

        $this->productRepository = new ProductRepository($this->entityManager);
    }

    public function testFindAllCallsDoctrineRepository(): void
    {
        $expectedProducts = [new Product(), new Product()];

        $this->doctrineRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($expectedProducts);

        $result = $this->productRepository->findAll();

        $this->assertSame($expectedProducts, $result);
    }

    public function testFindCallsDoctrineRepository(): void
    {
        $productId = '123';
        $expectedProduct = new Product();

        $this->doctrineRepository->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn($expectedProduct);

        $result = $this->productRepository->find($productId);

        $this->assertSame($expectedProduct, $result);
    }

    public function testStoreCallsEntityManager(): void
    {
        $product = new Product();

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($product);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->productRepository->store($product);
    }

    public function testDeleteCallsEntityManager(): void
    {
        $product = new Product();

        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with($product);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->productRepository->delete($product);
    }
}
