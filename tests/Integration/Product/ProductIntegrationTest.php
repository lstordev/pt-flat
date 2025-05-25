<?php

namespace App\Tests\Integration\Product;

use App\Product\Application\CreateProductUseCase;
use App\Product\Application\DeleteProductUseCase;
use App\Product\Application\GetAllProductsUseCase;
use App\Product\Application\GetProductByIdUseCase;
use App\Product\Application\UpdateProductUseCase;
use App\Product\Infrastructure\Persistence\Entity\Product;
use App\Product\Infrastructure\Persistence\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductIntegrationTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private ProductRepository $productRepository;
    private GetAllProductsUseCase $getAllProductsUseCase;
    private GetProductByIdUseCase $getProductByIdUseCase;
    private CreateProductUseCase $createProductUseCase;
    private UpdateProductUseCase $updateProductUseCase;
    private DeleteProductUseCase $deleteProductUseCase;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $this->entityManager = $container->get(EntityManagerInterface::class);
        $this->productRepository = new ProductRepository($this->entityManager);

        $this->getAllProductsUseCase = new GetAllProductsUseCase($this->productRepository);
        $this->getProductByIdUseCase = new GetProductByIdUseCase($this->productRepository);
        $this->createProductUseCase = new CreateProductUseCase($this->productRepository);
        $this->updateProductUseCase = new UpdateProductUseCase($this->productRepository);
        $this->deleteProductUseCase = new DeleteProductUseCase($this->productRepository);

        $this->entityManager->beginTransaction();
    }

    protected function tearDown(): void
    {
        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->rollback();
        }

        parent::tearDown();
    }

    public function testProductCrudOperations(): void
    {
        $productName = 'Test Product';
        $productPrice = 10.0;

        $this->createProductUseCase->execute($productName, $productPrice);

        $products = $this->getAllProductsUseCase->execute();
        $this->assertNotEmpty($products);

        $createdProduct = null;
        foreach ($products as $product) {
            if ($product->getName() === $productName && $product->getPrice() === $productPrice) {
                $createdProduct = $product;
                break;
            }
        }

        $this->assertNotNull($createdProduct);
        $productId = $createdProduct->getId();

        $retrievedProduct = $this->getProductByIdUseCase->execute((string) $productId);
        $this->assertNotNull($retrievedProduct);
        $this->assertEquals($productName, $retrievedProduct->getName());
        $this->assertEquals($productPrice, $retrievedProduct->getPrice());

        $updatedName = 'Updated Product';
        $updatedPrice = 20.0;

        $updatedProduct = $this->updateProductUseCase->execute(
            (string) $productId,
            $updatedName,
            $updatedPrice
        );

        $this->assertTrue($updatedProduct);

        $retrievedUpdatedProduct = $this->getProductByIdUseCase->execute((string) $productId);
        $this->assertEquals($updatedName, $retrievedUpdatedProduct->getName());
        $this->assertEquals($updatedPrice, $retrievedUpdatedProduct->getPrice());

        $deleteResult = $this->deleteProductUseCase->execute((string) $productId);
        $this->assertTrue($deleteResult);

        $deletedProduct = $this->getProductByIdUseCase->execute((string) $productId);
        $this->assertNull($deletedProduct);
    }
}
