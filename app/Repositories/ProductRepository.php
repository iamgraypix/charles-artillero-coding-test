<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements ProductRepositoryInterface
{
   
    public function getAll()
    {
        $products = Cache::remember('products', random_int(120, 300), function () {
            return Product::paginate();
        });

        return $products;
    }

    public function createProduct(array $productDetails)
    {
        return Product::create($productDetails);
    }

    public function findProduct(int $id)
    {
        $key = "product_{$id}";

        $product = Cache::remember($key, random_int(120, 300), function () use ($id) {
            return Product::findOrFail($id);
        });

        return $product;
    }

    public function update(int $id, array $fields)
    {
        // update the product
        $product = $this->findProduct($id);
        $product->update($fields);

        // update the cache
        Cache::pull("product_{$id}");
        Cache::put("product_{$id}", $product, random_int(120, 300));

        return $product;
        
        
    }

    public function deleteProduct(int $id)
    {
        $product = $this->findProduct($id);
        $product->delete();

        Cache::forget("product_{$id}");
    }
}
