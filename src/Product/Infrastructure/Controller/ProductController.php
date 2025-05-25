<?php

namespace App\Product\Infrastructure\Controller;

use App\Product\Application\CreateProductUseCase;
use App\Product\Application\DeleteProductUseCase;
use App\Product\Application\GetAllProductsUseCase;
use App\Product\Application\GetProductByIdUseCase;
use App\Product\Application\UpdateProductUseCase;
use App\Product\Infrastructure\Request\ProductRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/products')]
final class ProductController extends AbstractController
{
    public function __construct(
        private GetAllProductsUseCase $getAllProductsUseCase,
        private GetProductByIdUseCase $getProductByIdUseCase,
        private CreateProductUseCase $createProductUseCase,
        private UpdateProductUseCase $updateProductUseCase,
        private DeleteProductUseCase $deleteProductUseCase,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route(path: '/', name: 'products.get', methods: ['GET'])]
    public function index(
        SerializerInterface $serializer,
    ): JsonResponse {
        $products = $this->getAllProductsUseCase->execute();

        return new JsonResponse(
            $serializer->serialize($products, JsonEncoder::FORMAT),
            json: true
        );
    }

    #[Route(path: '/', name: 'products.post', methods: ['POST'])]
    public function new(
        Request $request,
    ): Response {
        $data = $this->serializer->deserialize($request->getContent(), ProductRequest::class, 'json');
        $errors = $this->validationErrors($data);

        if ($errors) {
            return $this->json(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->createProductUseCase->execute($data->name, $data->price);

        return new JsonResponse(status: Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'products.get.id', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        $product = $this->getProductByIdUseCase->execute($id);
        if (!$product) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse(
            $this->serializer->serialize($product, JsonEncoder::FORMAT),
            json: true
        );
    }

    #[Route('/{id}', name: 'products.put.id', methods: ['PUT'])]
    public function edit(string $id, Request $request): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), ProductRequest::class, 'json');
        $errors = $this->validationErrors($data);

        if ($errors) {
            return $this->json(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $updatedProduct = $this->updateProductUseCase->execute($id, $data->name, $data->price);

        if (!$updatedProduct) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(status: Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'products.delete.id', methods: ['DELETE'])]
    public function delete(string $id): Response
    {
        $deleted = $this->deleteProductUseCase->execute($id);

        if (!$deleted) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(status: Response::HTTP_OK);
    }

    private function validationErrors(ProductRequest $request): ?array
    {
        $errors = $this->validator->validate($request);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $errorMessages;
        }

        return null;
    }
}
