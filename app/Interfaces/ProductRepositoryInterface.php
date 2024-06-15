<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();
    public function createProduct(array $productDetails);
    public function findProduct(int $id);
    public function update(int $id, array $fields);
    public function deleteProduct(int $id);
}