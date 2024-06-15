<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function getAllProduct()
    {
        return $this->productRepository->getAll();
    }

    public function getProductById($id)
    {
        return $this->productRepository->findProduct($id);
    }

    public function createProduct(array $details)
    {
        return $this->productRepository->createProduct($details);
    }

    public function updateProduct(int $id, array $fields)
    {
        return $this->productRepository->update($id, $fields);
    }

    public function deleteProduct(int $id)
    {
        $this->productRepository->deleteProduct($id);
    }
}
