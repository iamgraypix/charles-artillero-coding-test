<?php 

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::paginate();
    }

    public function createProduct(array $productDetails)
    {
        return Product::create($productDetails);
    }
    
    public function findProduct(int $id)
    {
        return Product::findOrFail($id);
    }

    public function update(int $id, array $fields)
    {
        $product = $this->findProduct($id);
        
        $product->update($fields);
    }

    public function deleteProduct(int $id)
    {
        $product = $this->findProduct($id);

        $product->delete();
    }
}