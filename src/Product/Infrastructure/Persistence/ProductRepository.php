<?php

namespace App\Product\Infrastructure\Persistence;

use App\Product\Domain\ProductRepositoryInterface;
use App\Product\Infrastructure\Persistence\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

readonly class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function store(Product $product): void
    {
        $entityManager = $this->em;
        $entityManager->persist($product);
        $entityManager->flush();
    }

    public function save(Product $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }

    public function find(string $id): ?Product
    {
        return $this->em->getRepository(Product::class)->find($id);
    }

    public function findAll(): array
    {
        return $this->em->getRepository(Product::class)->findAll();
    }

    public function delete(Product $product): void
    {
        $this->em->remove($product);
        $this->em->flush();
    }
}
